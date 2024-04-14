export function useFormatCurrency(value) {
    return parseInt(value).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
    });
}
