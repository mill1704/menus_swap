@extends('welcome')

@section('content')

    {{-- @dump($menu_data) --}}

    <div class="w-9/12 mx-auto">
    {{-- <form action="{{ route('store') }}" name="module-menu" method="POST"> --}}
        {{-- @csrf --}}

        <table class="table-fixed border border-solid border-white w-full break-all">
            <thead>
                <th class="p-2.5 border-b border-solid border-white w-1/12"></th>
                <th class="p-2.5 border-b border-solid border-white text-left">name</th>
                {{-- <th class="p-2.5 border-b border-solid border-white text-left">link</th> --}}
                <th class="p-2.5 border-b border-solid border-white text-center">level</th>
                <th class="p-2.5 border-b border-solid border-white text-center">order_column</th>
                <th class="p-2.5 border-b border-solid border-white"></th>
            </thead>
            <tbody>
                <?php $order = 1 ?>
                @foreach ($menu_data['level1'] as $menu)
                    <tr id="menu-{{ $order }}" class="menu">
                        <td class="p-2.5 border-b border-solid border-white text-center">
                            {{ $order++ }}
                        </td>
                        <td class="p-2.5 border-b border-solid border-white">
                            {{ $menu->title }}
                        </td>
                        {{-- <td class="p-2.5 border-b border-solid border-white">
                            {{ $menu->url }}
                        </td> --}}
                        <td class="p-2.5 border-b border-solid border-white text-center">
                            {{ $menu->level }}
                        </td>
                        <td class="p-2.5 border-b border-solid border-white text-center">
                            {{ $menu->order_column }}
                        </td>
                        <td class="p-2.5 border-b border-solid border-white text-center">
                            <a href="javascript:void(0)"
                                class="up border border-solid border-white hover:bg-white hover:text-black w-1/2 float-left py-1 {{ $loop->first ? 'disabled' : '' }}">
                                <i class="fas fa-arrow-up"></i>
                            </a>
                            <a href="javascript:void(0)"
                                class="down border border-solid border-white hover:bg-white hover:text-black w-1/2 float-right py-1 {{ $loop->last ? 'disabled' : '' }}">
                                <i class="fas fa-arrow-down"></i>
                            </a>
                        </td>
                    </tr>
              
                    @if (isset($menu_data['level2'][$menu->menu_id]))
                        <?php $orderMain = $order - 1 ?>
                        <?php $orderSub = 1 ?>
                        @foreach ($menu_data['level2'][$menu->menu_id] as $menu_level2)
                            <tr id="submenu-{{ $orderMain }}-{{ $orderSub }}" class="submenu">
                                <td class="p-2.5 border-b border-solid border-white text-right">
                                    {{-- {{ $menu_level2->menu_id }} --}}
                                    {{ $orderMain }} - {{ $orderSub++ }}
                                </td>
                                <td class="p-2.5 border-b border-solid border-white">
                                    &emsp;&emsp;{{ $menu_level2->title }}
                                </td>
                                {{-- <td class="p-2.5 border-b border-solid border-white">
                                    {{ $menu_level2->url }}
                                </td> --}}
                                <td class="p-2.5 border-b border-solid border-white text-center">
                                    {{ $menu_level2->level }}
                                </td>
                                <td class="p-2.5 border-b border-solid border-white text-center">
                                    {{ $menu_level2->order_column }}
                                </td>
                                <td class="p-2.5 border-b border-solid border-white text-center">
                                    <a href="javascript:void(0)"
                                        class="up border border-solid border-white hover:bg-white hover:text-black w-1/2 float-left py-1 {{ $loop->first ? 'disabled' : '' }}">
                                        <i class="fas fa-arrow-up"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="down border border-solid border-white hover:bg-white hover:text-black w-1/2 float-right py-1 {{ $loop->last ? 'disabled' : '' }}">
                                        <i class="fas fa-arrow-down"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                @endforeach
            </tbody>
        </table>
    {{-- </form> --}}
    </div>
@endsection

@section('js')
<script src="{{ url('assets/js/jquery-swapsies.js') }}"></script>
<script src="{{ url('assets/js/jquery.serialize-object.js') }}"></script>

<script>
    $(function() {

        let j = {!! json_encode($menu_data) !!}
        console.log(j)

        // let x = $('.menu').each(function(index) {
        //     let y = $(this).attr('id')
        //     console.log(`${index} - ${y}`)
        // });

        $('table').on('click', '.up, .down', function(e) {
            e.preventDefault();
            var action    = ($(this).hasClass('down')) ? 'down' : 'up';
            var elm       = $(this).closest('.menu');
            var currentId = elm.attr('id');
            var nextId    = elm.nextAll('tr[class="menu"]:first').attr('id');
            var prevId    = elm.prevAll('tr[class="menu"]:first').attr('id');
            var swapId    = (action == 'down') ? nextId : prevId;

            // console.log(prevId + ' ' + currentId + ' ' + nextId)

            if (swapId) {

                $('#' + currentId).swap({
                    target: swapId,
                    opacity: '0.5',
                    speed: 500,
                    callback: function() {
                        var first = $('#' + currentId);
                        var second = $('#' + swapId);
                        swapElements(first[0], second[0]);
                        first.css('top', 0);
                        second.css('top', 0);
                        menuOrder();

                        // location.reload();
                        // Save orders
                        // var orders = $('form[name="module-menu"]').serialize();
                        // var url = urlWithoutParams() + '/store';

                        // $.post(orders).done(function (data) {});

                        // console.log(url)

                        // $('tr[class^="position"]').each(function() {
                        //     let x = $(this).attr('id')
                        //     console.log(x)
                        // });

                        // let j = {!! json_encode($menu_data['level1']) !!}
                        // console.log(j)
                    }
                });
            }
        });
    });

    // swap Dom Element function
    function swapElements(elm1, elm2) {

        var parent1, next1, parent2, next2;

        parent1 = elm1.parentNode;
        next1   = elm1.nextSibling;
        parent2 = elm2.parentNode;
        next2   = elm2.nextSibling;

        parent1.insertBefore(elm2, next1);
        parent2.insertBefore(elm1, next2);
    }

    function menuOrder() {
        let x = $('.menu').each(function(index) {
            let y = $(this).attr('id')
            // console.log(`${index} - ${y}`)
        });
    }

    // Get Full Current URL without parameters
    // function urlWithoutParams()  {
    //     return '//' + window.location.host + window.location.pathname;
    // }
</script>
@endsection
