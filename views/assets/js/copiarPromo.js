async function copyPromotion(promoCode) {
    try {
        // Copiar al portapapeles
        await navigator.clipboard.writeText(promoCode);
        
        // Mostrar SweetAlert de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: 'El código de promoción se ha copiado al portapapeles',
            showConfirmButton: false,
            timer: 2000, // Se cierra automáticamente en 2 segundos
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
        
    } catch (err) {
        // Fallback para navegadores más antiguos
        try {
            const textArea = document.createElement('textarea');
            textArea.value = promoCode;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            // Mostrar SweetAlert de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Copiado!',
                text: 'El código de promoción se ha copiado al portapapeles',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
            
        } catch (fallbackErr) {
            // Si todo falla, mostrar error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo copiar el código. Por favor, cópialo manualmente.',
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true
            });
        }
    }
}