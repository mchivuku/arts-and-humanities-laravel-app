@if(\Session::has('message'))

    <?php
    $message = \Session::get('message');

    ?>

    <section class="collapsed bg-none section" id="alert">
        <div class="row">
            <div class="layout">
                <div class="full-width">
                    <div class="text">
                        <div data-alert class="alert-box success radius">
                            {{$message}}
                            <a href="#" class="close">&times;</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endif
