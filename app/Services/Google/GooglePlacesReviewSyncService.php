<?php

declare(strict_types=1);

namespace App\Services\Google;

use App\Models\GoogleReview;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final readonly class GooglePlacesReviewSyncService
{
    public function sync(): int
    {
        $apiKey = config('services.google_places.api_key');
        $placeId = config('services.google_places.place_id');
        $minRating = (int) config('services.google_places.min_review_rating', 4);

        if (! is_string($apiKey) || trim($apiKey) === '') {
            throw new RuntimeException('GOOGLE_PLACES_API_KEY is not configured.');
        }

        if (! is_string($placeId) || trim($placeId) === '') {
            throw new RuntimeException('GOOGLE_PLACES_PLACE_ID is not configured.');
        }

        $response = Http::withHeaders([
            'X-Goog-Api-Key' => $apiKey,
            'X-Goog-FieldMask' => implode(',', [
                'id',
                'displayName',
                'rating',
                'userRatingCount',
                'reviews',
            ]),
        ])->get(sprintf('https://places.googleapis.com/v1/places/%s', $placeId), [
            'languageCode' => 'en',
        ]);

        if (! $response->successful()) {
            throw new RuntimeException(sprintf(
                'Google Places API error: HTTP %s. %s',
                $response->status(),
                $response->body(),
            ));
        }

        $reviews = $response->json('reviews', []);

        if (! is_array($reviews)) {
            return 0;
        }

        $synced = 0;

        foreach ($reviews as $index => $review) {
            if (! is_array($review)) {
                continue;
            }

            $rating = (int) ($review['rating'] ?? 0);

            if ($rating < $minRating) {
                continue;
            }

            $author = $review['authorAttribution'] ?? [];

            if (! is_array($author)) {
                $author = [];
            }

            $authorName = $author['displayName'] ?? 'Google User';

            $googleReviewName = $review['name'] ?? null;

            if (! is_string($googleReviewName) || $googleReviewName === '') {
                $googleReviewName = sha1(json_encode([
                    $authorName,
                    $review['publishTime'] ?? null,
                    $review['text']['text'] ?? $review['originalText']['text'] ?? null,
                ]));
            }

            $text = $review['text']['text']
                ?? $review['originalText']['text']
                ?? null;

            GoogleReview::query()->updateOrCreate(
                ['google_review_name' => $googleReviewName],
                [
                    'author_name' => $authorName,
                    'author_url' => $author['uri'] ?? null,
                    'author_photo_url' => $author['photoUri'] ?? $author['photoURI'] ?? null,
                    'rating' => $rating,
                    'text' => $text,
                    'relative_time_description' => $review['relativePublishTimeDescription'] ?? null,
                    'published_at' => isset($review['publishTime'])
                        ? Carbon::parse($review['publishTime'])
                        : null,
                    'is_active' => true,
                    'sort_order' => $index,
                    'payload' => $review,
                ],
            );

            $synced++;
        }

        return $synced;
    }
}

