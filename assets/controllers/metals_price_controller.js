import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['pair', 'price', 'storedAt', 'payload', 'button'];
    static values = {
        url: String,
        token: String,
    };

    async refresh() {
        this.buttonTarget.disabled = true;
        this.buttonTarget.textContent = 'Loading...';

        try {
            const formData = new FormData();

            // Is token really needed here? is that for the api key?
            formData.append('_token', this.tokenValue);

            const response = await fetch(this.urlValue, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },  
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.error || 'Refresh failed');
            }

            this.pairTarget.textContent = `${data.metal}/${data.currency}`;
            this.priceTarget.textContent = data.price;
            this.storedAtTarget.textContent = data.storedAt;
            // this.payloadTarget.textContent = JSON.stringify(data.payload, null, 4);
        } catch (error) {
            alert(error.message);
        } finally {
            this.buttonTarget.disabled = false;
            this.buttonTarget.textContent = 'Refresh price';
        }
    }
}
