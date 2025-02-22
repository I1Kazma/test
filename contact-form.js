document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.contact-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get message from either comment or message field
            const messageField = form.querySelector('[name="comment"]') || form.querySelector('[name="message"]');
            
            if (!messageField) {
                alert('Ошибка: поле сообщения не найдено');
                return;
            }

            const formData = {
                name: form.querySelector('[name="name"]').value,
                email: form.querySelector('[name="email"]').value,
                message: messageField.value
            };

            try {
                const response = await fetch('send_mail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                
                if (result.success) {
                    alert('Спасибо! Ваше сообщение успешно отправлено.');
                    form.reset();
                    
                    // Close modal if it exists
                    const modal = document.getElementById('contactModal');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                } else {
                    throw new Error(result.message || 'Неизвестная ошибка');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Произошла ошибка при отправке сообщения: ' + error.message);
            }
        });
    });
}); 