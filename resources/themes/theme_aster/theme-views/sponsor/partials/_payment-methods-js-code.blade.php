<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentCards = document.querySelectorAll('.payment-card');
        let selectedCard = null;
        
        paymentCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Create ripple effect
                createRipple(e, this);
                
                // Remove selected class from all cards
                paymentCards.forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked card
                this.classList.add('selected');
                selectedCard = this;
                
                // Remove existing hidden input
                const existingInput = document.querySelector('input[name="payment_method"]');
                if (existingInput) {
                    existingInput.remove();
                }
                
                // Create and append hidden input
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'payment_method';
                hiddenInput.value = this.getAttribute('data-payment-method');
                
                // Append to the card body
                this.querySelector('.card-body').appendChild(hiddenInput);
                
                // Optional: Log the selected payment method
                console.log('Selected payment method:', hiddenInput.value);
            });
            
            // Add hover sound effect (optional - you can remove this if not needed)
            card.addEventListener('mouseenter', function() {
                if (!this.classList.contains('selected')) {
                    this.style.transform = 'translateY(-5px)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                if (!this.classList.contains('selected')) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
        
        function createRipple(event, element) {
            const circle = document.createElement('div');
            const diameter = Math.max(element.clientWidth, element.clientHeight);
            const radius = diameter / 2;
            
            circle.classList.add('ripple');
            circle.style.width = circle.style.height = diameter + 'px';
            circle.style.left = (event.clientX - element.offsetLeft - radius) + 'px';
            circle.style.top = (event.clientY - element.offsetTop - radius) + 'px';
            
            element.appendChild(circle);
            
            // Remove ripple after animation
            setTimeout(() => {
                circle.remove();
            }, 600);
        }
    });
</script>