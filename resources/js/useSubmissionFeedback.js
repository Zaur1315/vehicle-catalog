import { ref } from 'vue';

export function useSubmissionFeedback() {
    const submissionError = ref('');
    const failure = () => {
        submissionError.value =
            'We could not confirm your request. Your details are still here. Please call us before sending again.';
        return false;
    };
    return {
        submissionError,
        feedback: {
            onBefore: () => {
                submissionError.value = '';
            },
            onHttpException: failure,
            onNetworkError: failure,
        },
    };
}
