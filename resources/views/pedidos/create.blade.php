@extends('adminlte::page')



@section('title', 'Crear Pedido')

@section('content_header')
    <h1>Crear Nuevo Pedido</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Información del Pedido</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Columna izquierda -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cliente_id">Cliente:</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" onchange="cargarCliente()">
                            <option value="">Seleccione un Cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Información del cliente se cargará aquí -->
                    <div id="infoCliente" style="margin-top: 20px;"></div>
                    <button type="button" class="btn btn-link" onclick="toggleNuevaDireccion()">+ Añadir nueva dirección</button>
                    <div id="nuevaDireccion" style="display: none; margin-top: 20px;">
                        <!-- Campos para añadir una nueva dirección -->
                        <h4>Nueva Dirección</h4>
                        <div class="form-group">
                            <label for="nueva_direccion_tipo">Tipo de Dirección:</label>
                            <input type="text" class="form-control" id="nueva_direccion_tipo" name="nueva_direccion_tipo">
                        </div>
                        <div class="form-group">
                            <label for="nueva_direccion">Dirección:</label>
                            <input type="text" class="form-control" id="nueva_direccion" name="nueva_direccion">
                        </div>
                        <div class="form-group">
                            <label for="nueva_ubicacion_id">Ubicación:</label>
                            <select class="form-control" id="nueva_ubicacion_id" name="nueva_ubicacion_id">
                                @foreach($ubicaciones as $ubicacion)
                                    <option value="{{ $ubicacion->id }}">{{ $ubicacion->region }} - {{ $ubicacion->comuna }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" data-url="{{ route('direcciones.store') }}" onclick="guardarNuevaDireccion()">Guardar Nueva Dirección</button>
                    </div>
                    <!-- Orden de compra y tipo de pedido -->
                    <div class="form-group">
                        <label for="orden_compra">Orden de Compra:</label>
                        <input type="text" class="form-control" id="orden_compra" name="orden_compra" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_pedido">Tipo de Pedido:</label>
                        <select class="form-control" id="tipo_pedido" name="tipo_pedido">
                            <option value="Pedido Normal">Pedido Normal</option>
                            <option value="Fcom">Fcom</option>
                        </select>
                    </div>
                </div>
                <!-- Columna derecha -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_pedido">Fecha del Pedido:</label>
                        <input type="date" class="form-control" id="fecha_pedido" name="fecha_pedido" value="{{ now()->toDateString() }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="comentarios">Comentarios:</label>
                        <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                    </div>
                </div>
            </div>

             {{-- Selector de Productos e Ingreso de Detalles del Ítem --}}
            <div class="card mt-4">
                <div class="card-header">
                    Agregar Ítems al Pedido
                </div>
                <div class="card-body">
                   <div class="form-group">
                        <label for="producto_id">Producto:</label>
                        <select class="form-control select2" id="producto_id" name="producto_id" onchange="mostrarInformacionProducto()">
                            <option value="">Seleccione un Producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Aquí se mostrará la información del producto seleccionado --}}
                    <div id="infoProducto" style="margin-top: 20px;"></div>

                    {{-- Botón para agregar el ítem al pedido (implementación JS necesaria) --}}
                    <button type="button" class="btn btn-success" onclick="agregarItemPedido()">Agregar Ítem al Pedido</button>
                </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">Resumen de Pedido</div>
                    <div class="card-body">
                        <table class="table" id="resumenPedido">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad de Cajas</th>
                                    <th>Precio Neto</th>
                                    <th>Costo de Envío</th>
                                    <th>Total Neto</th>
                                    <th>Total Envio</th>
                                    <th>Total Peso</th>
                                    <th>Acciones</th> <!-- Columna adicional para acciones -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los ítems se agregarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Total de Cajas -->
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fa fa-boxes fa-2x"></i>
                                <h5>Total Cajas</h5>
                                <p id="totalCajas">0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Monto Neto Total -->
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fa fa-dollar-sign fa-2x"></i>
                                <h5>Monto Neto Total</h5>
                                <p id="montoNetoTotal">0</p>
                            </div>
                        </div>
                    </div>

                    <!-- Peso Total -->
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fa fa-weight-hanging fa-2x"></i>
                                <h5>Peso Total</h5>
                                <p id="pesoTotal">0 kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Costo de Envío Total -->
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fa fa-truck fa-2x"></i>
                                <h5>Costo de Envío</h5>
                                <p id="costoEnvioTotal">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Crear Pedido</button>
            </div>
        </form>

        <div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalExitoLabel">Éxito</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Dirección agregada con éxito.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
@stop

@section('js')
    <script>
    function toggleNuevaDireccion() {
        var x = document.getElementById("nuevaDireccion");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
    function cargarCliente() {
        var clienteId = document.getElementById('cliente_id').value;
        if (!clienteId) {
            document.getElementById('infoCliente').innerHTML = '';
            return;
        }

        fetch(`/clientes/info/${clienteId}`)
        .then(response => response.json())
        .then(data => {
            const infoClienteDiv = document.getElementById('infoCliente');
            let htmlContent = `
                <h3>Información del Cliente</h3>
                <p><strong>Nombre:</strong> ${data.nombre}</p>
                <p><strong>RUT:</strong> ${data.rut}</p>
                <p><strong>Fono:</strong> ${data.fono}</p>
                <p><strong>Contacto:</strong> ${data.nombre_contacto} / ${data.fono_contacto}</p>
                <p><strong>Dirección Matriz:</strong> ${data.direccion_matriz}</p>
                <h4>Direcciones de Envío</h4>
                <select class="form-control" id="direccionEnvio" name="direccionEnvio">`;
                    data.direcciones.forEach(direccion => {
                        htmlContent += `<option value="${direccion.id}">${direccion.tipo}: ${direccion.direccion}</option>`;
                    });htmlContent += `</select>`;

            infoClienteDiv.innerHTML = htmlContent;
        })
        .catch(error => {
            console.error('Error al cargar la información del cliente:', error);
            document.getElementById('infoCliente').innerHTML = '<p>Error al cargar la información del cliente.</p>';
        });
    }
    function guardarNuevaDireccion() {
        var clienteId = document.getElementById('cliente_id').value;
        var tipo = document.getElementById('nueva_direccion_tipo').value;
        var direccion = document.getElementById('nueva_direccion').value;
        var ubicacionId = document.getElementById('nueva_ubicacion_id').value;
        var url = document.querySelector('button[data-url]').getAttribute('data-url');

        var formData = new FormData();
        formData.append('cliente_id', clienteId);
        formData.append('tipo', tipo);
        formData.append('direccion', direccion);
        formData.append('ubicacion_id', ubicacionId);
        formData.append('_token', '{{ csrf_token() }}'); // Asegúrate de que esto está correcto para tu configuración de Laravel

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Oculta el formulario de nueva dirección
                document.getElementById('nuevaDireccion').style.display = 'none';

                // Actualiza el select de direcciones
                var selectDirecciones = document.getElementById('direccionEnvio');
                selectDirecciones.innerHTML = ''; // Limpia el select actual
                data.direcciones.forEach(direccion => {
                    var option = new Option(`${direccion.tipo}: ${direccion.direccion}`, direccion.id);
                    selectDirecciones.add(option);
                });

                // Muestra el modal de éxito
                $('#modalExito').modal('show'); // Si estás usando Bootstrap con jQuery
                // O si estás usando Bootstrap sin jQuery en su versión más reciente:
                // var modalExito = new bootstrap.Modal(document.getElementById('modalExito'));
                // modalExito.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    function mostrarInformacionProducto() {
        var productoId = document.getElementById('producto_id').value;
        if (!productoId) {
            document.getElementById('infoProducto').innerHTML = '';
            return;
        }
        fetch(`/productos/info/${productoId}`)
        .then(response => response.json())
        .then(data => {
            const infoDiv = document.getElementById('infoProducto');
            // Asumiendo que data.peso proporciona el peso del producto
            let htmlContent = `
                <p><strong>Código SKU:</strong> ${data.codigo_sku}</p>
                <p><strong>Nombre:</strong> ${data.nombre}</p>
                <p><strong>Stock disponible:</strong> ${data.stock}</p>
                <p><strong>Peso por unidad:</strong> ${data.peso} kg</p> <!-- Mostrar peso aquí -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad_cajas">Cantidad de Cajas:</label>
                            <input type="number" class="form-control" id="cantidad_cajas" name="cantidad_cajas">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="precio_neto">Precio Neto:</label>
                            <input type="number" class="form-control" id="precio_neto" name="precio_neto" step="0.01">
                        </div>
                    </div>
                    <div class="form-group">
                <label for="costo_envio">Costo de Envío:</label>
                <input type="number" class="form-control" id="costo_envio" name="costo_envio" step="0.01" required>
            </div>
                </div>
            `;
            // Guarda el peso por unidad en un lugar accesible, por ejemplo, como un atributo del div infoProducto
            infoDiv.setAttribute('data-peso', data.peso);

            infoDiv.innerHTML = htmlContent;
        });
    }
    function agregarItemPedido() {
        var productoId = document.getElementById('producto_id').value;
        var productoNombre = document.querySelector('#producto_id option:checked').text;
        var cantidadCajas = parseInt(document.getElementById('cantidad_cajas').value, 10);
        var precioNetoUnitario = parseFloat(document.getElementById('precio_neto').value);
        var costoEnvioUnitario = parseFloat(document.getElementById('costo_envio').value);
        var pesoPorUnidad = parseFloat(document.getElementById('infoProducto').getAttribute('data-peso'));

        if (!productoId || isNaN(cantidadCajas) || isNaN(precioNetoUnitario) || isNaN(costoEnvioUnitario) || isNaN(pesoPorUnidad)) {
            alert("Por favor, complete todos los campos del ítem, incluyendo el peso.");
            return;
        }

        var index = document.querySelectorAll('#resumenPedido tbody tr').length;
        var resumenPedido = document.getElementById('resumenPedido').getElementsByTagName('tbody')[0];
        var nuevaFila = resumenPedido.insertRow();

        nuevaFila.innerHTML = `
            <td>${productoNombre}<input type="hidden" name="items[${index}][producto_id]" value="${productoId}"></td>
            <td>${cantidadCajas}<input type="hidden" name="items[${index}][cantidad]" value="${cantidadCajas}"></td>
            <td>$${precioNetoUnitario.toFixed(2)}<input type="hidden" name="items[${index}][precio_neto]" value="${precioNetoUnitario}"></td>
            <td>$${costoEnvioUnitario.toFixed(2)}<input type="hidden" name="items[${index}][costo_envio]" value="${costoEnvioUnitario}"></td>
            <td>$${(cantidadCajas * precioNetoUnitario).toFixed(2)}</td>
            <td>$${(cantidadCajas * costoEnvioUnitario).toFixed(2)}</td>
            <td>${(cantidadCajas * pesoPorUnidad).toFixed(2)} kg</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarItemPedido(this)">Eliminar</button></td>
        `;

        actualizarResumenPedido();
    }
    function eliminarItemPedido(button) {
        // Obtiene la fila (tr) en la que el botón de eliminar fue presionado
        var fila = button.closest('tr');
        // Elimina la fila del tbody
        fila.remove();
        // Llama a actualizarResumenPedido para recalcular los totales
        actualizarResumenPedido();
    }
    function actualizarResumenPedido() {
        var totalCajas = 0;
        var montoNetoTotal = 0;
        var costoEnvioTotal = 0;
        var pesoTotal = 0;

        document.querySelectorAll("#resumenPedido tbody tr").forEach(fila => {
            var cajas = parseInt(fila.cells[1].textContent, 10);
            var neto = parseFloat(fila.cells[4].textContent.replace('$', ''));
            var envio = parseFloat(fila.cells[5].textContent.replace('$', ''));
            var peso = parseFloat(fila.cells[6].textContent.replace(' kg', ''));

            totalCajas += cajas;
            montoNetoTotal += neto;
            costoEnvioTotal += envio;
            pesoTotal += peso;
        });

        document.getElementById("totalCajas").textContent = totalCajas;
        document.getElementById("montoNetoTotal").textContent = `$${montoNetoTotal.toFixed(2)}`;
        document.getElementById("costoEnvioTotal").textContent = `$${costoEnvioTotal.toFixed(2)}`;
        document.getElementById("pesoTotal").textContent = `${pesoTotal.toFixed(2)} kg`;
    }
    // Llama a actualizarResumenPedido dentro de agregarItemPedido y cualquier otra función que modifique los ítems
    </script>
@stop
