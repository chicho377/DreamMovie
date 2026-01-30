function actualizarLineaPasos(num) {
            var totalPasos = $('.compra-pasos .paso').length;
            // La línea debe llegar solo hasta el centro de la bola activa
            var porcentaje = ((num-1+0.5)/(totalPasos-1))*100;
            $('#lineaActiva').css('width', porcentaje+'%');
        }
        // Al seleccionar cine, llenar los días desde hoy hasta una semana
        $('#cine').change(function(){
            var hoy = new Date();
            var diasSemana = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
            var opciones = '<option value="">Seleccione un día</option>';
            for(var i=0;i<7;i++){
                var fecha = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate()+i);
                var yyyy = fecha.getFullYear();
                var mm = (fecha.getMonth()+1).toString().padStart(2,'0');
                var dd = fecha.getDate().toString().padStart(2,'0');
                var valor = yyyy+'-'+mm+'-'+dd;
                var nombreDia = diasSemana[fecha.getDay()];
                var texto = '';
                var fechaStr = dd+'/'+mm+'/'+yyyy;
                if(i === 0){
                    texto = 'Hoy ('+nombreDia+') - '+fechaStr;
                }else{
                    texto = nombreDia+' - '+fechaStr;
                }
                opciones += '<option value="'+valor+'">'+texto+'</option>';
            }
            $('#dia').html(opciones);
        });
    $(document).ready(function(){
        // Navegación entre pasos
        let maxStep = 1;
        function activarPaso(num) {
            $('.paso').removeClass('active');
            $('.paso' + num).addClass('active');
        }
        function mostrarPaso(num) {
            for(let i=1;i<=6;i++) $('#step'+i).hide();
            $('#step'+num).show();
            activarPaso(num);
            actualizarLineaPasos(num);
        }

    mostrarPaso(1);
    actualizarLineaPasos(1);

        // Click en los pasos para navegar solo si ya se han pasado
        $('.compra-pasos .paso').each(function(){
            var step = $(this).data('step');
            $(this).css('cursor','pointer').off('click').on('click', function(){
                if(step && step <= maxStep){
                    mostrarPaso(step);
                }
            });
        });

        // Botones Anterior
        $('#prev2').click(function(){ mostrarPaso(1); });
        $('#prev3').click(function(){ mostrarPaso(2); });
        $('#prev4').click(function(){ mostrarPaso(3); });
        $('#prev5').click(function(){ mostrarPaso(4); });
        $('#prev6').click(function(){ mostrarPaso(5); });

        $('#next1').click(function(){
            if($('#cine').val() && $('#dia').val()){
                mostrarPaso(2);
                maxStep = Math.max(maxStep,2);
                // Cargar películas
                $.post('ajax_get_peliculas.php', {cine: $('#cine').val(), dia: $('#dia').val()}, function(data){
                    $('#pelicula').html(data);
                });
            }else{
                Swal.fire({text: 'Seleccione cine y fecha.', icon: 'warning', confirmButtonColor: '#00eaff'});
            }
        });
        $('#next2').click(function(){
            if($('#pelicula').val()){
                mostrarPaso(3);
                maxStep = Math.max(maxStep,3);
                // Cargar salas
                $.post('ajax_get_salas.php', {cine: $('#cine').val(), dia: $('#dia').val(), pelicula: $('#pelicula').val()}, function(data){
                    $('#sala').html(data);
                });
            }else{
                Swal.fire({text: 'Seleccione una película.', icon: 'warning', confirmButtonColor: '#00eaff'});
            }
        });
        $('#next3').click(function(){
            if($('#sala').val() && $('#hora').val()){
                mostrarPaso(4);
                maxStep = Math.max(maxStep,4);
            }else{
                Swal.fire({text: 'Seleccione sala y hora.', icon: 'warning', confirmButtonColor: '#00eaff'});
            }
        });
        $('#sala').change(function(){
            var sala = $('#sala').val();
            var dia = $('#dia').val();
            var pelicula = $('#pelicula').val();
            if(sala && dia && pelicula){
                $.post('ajax_get_horas.php', {sala: sala, dia: dia, pelicula: pelicula}, function(data){
                    $('#hora').html(data);
                });
            }
        });
        $('#next4').click(function(){
            var total = parseInt($('#adulto').val()) + parseInt($('#nino').val()) + parseInt($('#mayor').val());
            if(total > 0){
                mostrarPaso(5);
                maxStep = Math.max(maxStep,5);
                cargarButacasOcupadas(total);
            }else{
                Swal.fire({text: 'Seleccione al menos una entrada.', icon: 'warning', confirmButtonColor: '#00eaff'});
            }
        });
        $('#next5').click(function(){
            var total = parseInt($('#adulto').val()) + parseInt($('#nino').val()) + parseInt($('#mayor').val());
            var asientos = $('#asientos').val().split(',');
            if(asientos.length == total && asientos[0] !== ''){
                mostrarPaso(6);
                maxStep = Math.max(maxStep,6);
                mostrarResumen();
            }else{
                Swal.fire({text: 'Seleccione la cantidad de butacas correspondiente.', icon: 'warning', confirmButtonColor: '#00eaff'});
            }
        });

        // Mostrar resumen de compra
        let descuentoPromo = 0;
        let promoAplicado = '';
        function mostrarResumen(){
            var cine = $('#cine option:selected').text();
            var dia = $('#dia').val();
            var pelicula = $('#pelicula option:selected').text();
            var sala = $('#sala option:selected').text();
            var hora = $('#hora').val();
            var adulto = parseInt($('#adulto').val());
            var nino = parseInt($('#nino').val());
            var mayor = parseInt($('#mayor').val());
            var asientos = $('#asientos').val();
            var totalEntradas = adulto*3500 + nino*2000 + mayor*2500;
            var tarifaServicios = 350;
            var total = totalEntradas + tarifaServicios - descuentoPromo;
            var html = '';
            html += '<div class="resumen-item"><span>Cine:</span><span>'+cine+'</span></div>';
            html += '<div class="resumen-item"><span>Fecha:</span><span>'+dia+'</span></div>';
            html += '<div class="resumen-item"><span>Película:</span><span>'+pelicula+'</span></div>';
            html += '<div class="resumen-item"><span>Sala:</span><span>'+sala+'</span></div>';
            html += '<div class="resumen-item"><span>Hora:</span><span>'+hora+'</span></div>';
            html += '<div class="resumen-item"><span>Entradas:</span><span>';
            if(adulto>0) html += adulto+' Adulto '; 
            if(nino>0) html += nino+' Niño '; 
            if(mayor>0) html += mayor+' Adulto Mayor';
            html += '</span></div>';
            html += '<div class="resumen-item"><span>Butacas:</span><span>'+asientos+'</span></div>';
            html += '<div class="resumen-item"><span>Tarifa de servicios:</span><span>₡'+tarifaServicios+'</span></div>';
            if(descuentoPromo > 0){
                html += '<div class="resumen-item" style="color:#7c4dff;"><span>Descuento promocional ('+promoAplicado+'):</span><span>-₡'+descuentoPromo+'</span></div>';
            }
            html += '<div class="resumen-total">Total: ₡'+total+'</div>';
            $('#resumen-body').html(html);
        }

        $('#aplicarCodigo').click(function(){
            var codigo = $('#codigo_promocional').val().trim().toUpperCase();
            var fechaStr = $('#dia').val();
            var partes = fechaStr.split('-');
            var hoy = new Date(partes[0], partes[1]-1, partes[2]); // Año, mes (0-index), día
            var diaSemana = hoy.getDay(); // 0=Domingo, 1=Lunes, ..., 6=Sábado
            descuentoPromo = 0;
            promoAplicado = '';
            if(codigo === 'DREAM2X1' && diaSemana === 3){
                // Aplica 2x1 solo viernes, solo para adultos
                var adulto = parseInt($('#adulto').val());
                if(adulto >= 2){
                    descuentoPromo = 3500;
                    promoAplicado = codigo;
                    Swal.fire({text: '¡Código DREAM2X1 aplicado! 2x1 en adultos.', icon: 'success', confirmButtonColor: '#00eaff'});
                }else{
                    Swal.fire({text: 'El código DREAM2X1 requiere al menos 2 entradas de adulto.', icon: 'warning', confirmButtonColor: '#00eaff'});
                }
            }else if(codigo === 'DREAM2X1'){
                Swal.fire({text: 'El código DREAM2X1 solo es válido los viernes.', icon: 'error', confirmButtonColor: '#00eaff'});
            }else if(codigo.length > 0){
                Swal.fire({text: 'Código promocional no válido.', icon: 'error', confirmButtonColor: '#00eaff'});
            }
            mostrarResumen();
        });

        // ...existing code for AJAX and butacas...
        // Paso 5: Selección de entradas habilita butacas
        $('#adulto, #nino, #mayor').change(function(){
            var total = parseInt($('#adulto').val()) + parseInt($('#nino').val()) + parseInt($('#mayor').val());
            if(total > 0 && $('#step5').is(':visible')){
                cargarButacasOcupadas(total);
            }
        });

        function cargarButacasOcupadas(total) {
            var sala = $('#sala').val();
            var dia = $('#dia').val();
            var hora = $('#hora').val();
            var pelicula = $('#pelicula').val();
            $.post('ajax_get_asientos_ocupados.php', {sala: sala, dia: dia, hora: hora, pelicula: pelicula}, function(data){
                var ocupados = [];
                try {
                    ocupados = JSON.parse(data);
                } catch(e) {}
                renderSeatGrid(total, ocupados);
            });
        }

        function renderSeatGrid(total, ocupados) {
            var filas = 5;
            var columnas = 8;
            var letras = ['A','B','C','D','E'];
            var selectedSeats = [];
            // Define los asientos discapacitados
            var discapacitados = ['B1', 'D8'];
            var html = '<div style="display:flex; flex-direction:column; align-items:center;">';
            for(var r=0; r<filas; r++){
                html += '<div class="fila-asientos">';
                html += '<span class="letra-fila">'+letras[r]+'</span>';
                for(var c=1; c<=columnas; c++){
                    var seatId = letras[r]+c;
                    var ocupado = ocupados.includes(seatId);
                    var esDiscapacitado = discapacitados.includes(seatId);
                    var clase = ocupado ? 'asiento ocupado' : 'asiento disponible';
                    if(esDiscapacitado) clase += ' discapacitado';
                    // En la función renderSeatGrid, reemplaza el SVG por solo el número:
                    html += '<span class="'+clase+'" data-seat="'+seatId+'">'+c+'</span>';
                }
                html += '</div>';
            }
            html += '</div>';
            html += '<input type="hidden" name="asientos" id="asientos" />';
            $('#butacas').html(html);

            $('.asiento.disponible, .asiento.disponible.discapacitado').off('click').on('click', function(){
                var seat = $(this).data('seat');
                if($(this).hasClass('seleccionado')){
                    $(this).removeClass('seleccionado');
                    selectedSeats = selectedSeats.filter(s => s !== seat);
                }else{
                    if(selectedSeats.length < total){
                        $(this).addClass('seleccionado');
                        selectedSeats.push(seat);
                    }else{
                        Swal.fire({text: 'Ya seleccionaste todas las butacas.', icon: 'info', confirmButtonColor: '#00eaff'});
                    }
                }
                $('#asientos').val(selectedSeats.join(','));
            });
        }
    });