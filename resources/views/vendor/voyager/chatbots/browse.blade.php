@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        {{-- <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1> --}}
        {{-- @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach --}}
        {{-- @include('voyager::multilingual.language-selector') --}}
    </div>
@stop

@section('content')

    <div class="container-fluid">
        <div class="messaging">
            <div class="inbox_msg">
              <div class="inbox_people">
                <div class="headind_srch">
                  <div class="recent_heading">
                    <h4>Chats</h4>
                  </div>
                  <div class="srch_bar">
                    <div class="stylish-input-group">
                        <input type="text" class="srch_bar form-control"  placeholder="Buscar" id="misearch">
                    </div>
                  </div>
                </div>
                <div class="inbox_chat">
                    <div id="miinbox"></div>
                </div>
              </div>
              <div class="mesgs">
                <div class="msg_history">
                    <div id="listchats"></div>
                </div>
                <div class="type_msg">
                  <div class="input_msg_write">
                        <input type="text" id="client_phone" placeholder="phone" hidden>
                        <input id="mimessage" type="text" class="write_msg" placeholder="Escribe el mensaje" />
                        <button class="msg_send_btn" type="button" onclick="message_send()"><i class="voyager-rocket" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @include('voyager::alerts')
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-primary fade" tabindex="-1" id="cliente_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-helm"></i> Relacion el Chatbot con un Cliente </h4>
                </div>
                <div class="modal-body">
                    <input type="text" id="chatbot_id" hidden>
                    <input id="search_cliente" type="text" class="form-control" placeholder="buscar cliente">
                    <table class="table" id="table_cliente">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>display</th>
                                <th>Registro</th>
                                <th>Asignar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
    <style>
        img{ max-width:100%;}
        .inbox_people {
        background: #f8f8f8 none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 40%; border-right:1px solid #c4c4c4;
        }

        .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
        }

        .top_spac{ margin: 20px 0 0;}
        .recent_heading {float: left; width:40%;}

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
        }

        .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

        .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
        }
        .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
        .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
        }

        .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

        .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
        .chat_ib h5 span{ font-size:13px; float:right;}
        .chat_ib p{ font-size:14px; color:#989898; margin:auto}
        .chat_img {
        float: left;
        width: 11%;
        }
        .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
        }

        .chat_people{ overflow:hidden; clear:both;}
        .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
        }

        .inbox_chat { height: 550px; overflow-y: scroll;}

        .active_chat{ background:#ebebeb;}

        .incoming_msg_img {
        display: inline-block;
        width: 6%;
        }

        .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
        }

        .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
        }

        .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
        }

        .received_withd_msg { width: 57%;}
        .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
        }

        .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0; color:#fff;
        padding: 5px 10px 5px 12px;
        width:100%;
        }

        .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
        .sent_msg {
        float: right;
        width: 46%;
        }

        .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
        }

        .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
        .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
        }

        .messaging { padding: 0 0 50px 0;}
        .msg_history {
        height: 700px;
        overflow-y: auto;
        }
    </style>
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://socket.loginweb.dev/socket.io/socket.io.js"></script>
    <script>
        const socket = io('https://socket.loginweb.dev')
        socket.on('chatbot', (msg) =>{
            $("#client_phone").val(msg)
            list_inbox()
            chat_set(msg)
            toastr.info('Nuevo mensaje de: '+msg)
        })
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [
                            ['targets' => 'dt-not-orderable', 'searchable' =>  false, 'orderable' => false],
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
            list_inbox()
        });

        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                    }else{
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                    }
                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });

        async function chat_set(phone) {
            var messages = await axios("{{ setting('admin.url') }}api/chatbot/chats/"+phone)
            var listchats = ''
            for (let index = 0; index < messages.data.length; index++) {
                if (messages.data[index].type == 'input') {
                    listchats = listchats + "<div class='incoming_msg'><div class='incoming_msg_img'><img src='https://pos.loginweb.dev/storage/chatbots/cliente_avatar.png'></div><div class='received_msg'><div class='received_withd_msg'><p>"+messages.data[index].message+"</p><span class='time_date'>"+messages.data[index].published+"</span></div></div></div>"
                } else {
                    listchats = listchats + "<div class='outgoing_msg'><div class='sent_msg'><p>"+messages.data[index].message+"</p><span class='time_date'>"+messages.data[index].published+"</span> </div></div>"
                }
            }
            $("#misearch").val(phone)
            $("#client_phone").val(phone)
            $("#listchats").html(listchats)
            $("#mimessage").val('')
            $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1000)
        }

        async function message_send() {
            var phone = $("#client_phone").val()
            var message = $("#mimessage").val()
            var midata = {
                phone: phone,
                message: message
            }
            toastr.success('Mensaje enviado a: '+phone)
            await axios.post("{{ setting('admin.url') }}api/chatbot/save/out", midata)

            var datapost = {
                phone: phone,
                type: 'text',
                message: message
            }
            await axios.post("https://chatbot.loginweb.dev/chat", datapost)
            chat_set(phone)
        }

        $("#mimessage").keyup(function(e)
        {
            if (e.keyCode == 13)
            {
                message_send()
            }
        });

        //list inbox
        async function list_inbox() {
            var miinbox = await axios("{{ setting('admin.url') }}api/chatbot/inbox")
            var listchats = ''
            for (let index = 0; index < miinbox.data.length; index++) {
                var aux_chat = await axios("{{ setting('admin.url') }}api/chatbots/"+miinbox.data[index].phone)
                var aux_cliente = await axios("{{ setting('admin.url') }}api/chatbot/cliente/get/"+miinbox.data[index].phone)
                if (aux_cliente.data) {
                    listchats = listchats + `<div class='chat_list'><div class='chat_people'><a href='#' onclick='chat_set("${miinbox.data[index].phone}")'><div class='chat_img'><img src='https://pos.loginweb.dev/storage/chatbots/cliente_avatar.png'></div><div class='chat_ib'><h5>${miinbox.data[index].phone}<span class='chat_date'>${aux_chat.data.published}</span></h5></div></a></div>${aux_cliente.data.display}</div>`
                } else {
                    listchats = listchats + `<div class='chat_list'><div class='chat_people'><a href='#' onclick='chat_set("${miinbox.data[index].phone}")'><div class='chat_img'><img src='https://pos.loginweb.dev/storage/chatbots/cliente_avatar.png'></div><div class='chat_ib'><h5>${miinbox.data[index].phone}<span class='chat_date'>${aux_chat.data.published}</span></h5></div></a></div><a href='#' onclick='cliente_relacion("${miinbox.data[index].phone}")'>Relacionar Cliente<a></div>`
                }
            }
            $("#miinbox").html(listchats)
        }

        function cliente_relacion(chatbot_id) {
            $('#chatbot_id').val(chatbot_id);
            $('#cliente_modal').modal('show');
        }

        $("#search_cliente").keyup(async function(e)
        {
            if (e.keyCode == 13)
            {
                $('#table_cliente tbody tr').remove();
                var clientes = await axios.post("{{ setting('admin.url') }}api/chatbot/cliente/search", {criterio: this.value})
                console.log(clientes.data)
                for (let index = 0; index < clientes.data.length; index++) {
                    $('#table_cliente').append("<tr><td>"+clientes.data[index].id+"</td><td>"+clientes.data[index].display+"</td><td>"+clientes.data[index].published+"</td><td><a href='#' class='btn btn-xs btn-dark' onclick='cliente_set("+clientes.data[index].id+", "+clientes.data[index].id+")'>OK</a></td></tr>")
                }
            }
        });

        async function cliente_set(cliente_id) {
            var chatbot_id =  $('#chatbot_id').val()
            await axios.post("{{ setting('admin.url') }}api/chatbot/cliente/relacion", {cliente_id: cliente_id, chatbot_id: chatbot_id})
            toastr.info('Chat Realacionado')
            $('#cliente_modal').modal('toggle');
        }
    </script>
@stop
