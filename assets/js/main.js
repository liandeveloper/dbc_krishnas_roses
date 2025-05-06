function toggleNav() {
    const sidebar = document.getElementById("navMenu");
    sidebar.classList.toggle("nav-ver-open");
}

function redirectToWhatsApp(buttonElement) {
    // Obtener el elemento padre (div.product) que contiene toda la información del producto
    const productCard = buttonElement.closest('.product');
    
    // Extraer la información necesaria
    const productId = productCard.id;
    const description = productCard.querySelector('.product-description').textContent;
    const price = productCard.querySelector('.product-info-price').textContent;
    
    // Número de teléfono (reemplaza con tu número real, incluyendo código de país)
    const phoneNumber = '5355105070'; // Ejemplo: México (52) + 1234567890
    
    // Crear el mensaje con la información del producto
    const message = `¡Hola! Estoy interesado en comprar este producto:\n\n` +
                   `*ID:* ${productId}\n` +
                   `*Descripción:* ${description}\n` +
                   `*Precio:* ${price}\n\n` +
                   `Por favor, indíqueme cómo proceder con la compra.`;
    
    // Codificar el mensaje para URL
    const encodedMessage = encodeURIComponent(message);
    
    // Crear el enlace de WhatsApp
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    
    // Redirigir al usuario
    window.open(whatsappUrl, '_blank');
}