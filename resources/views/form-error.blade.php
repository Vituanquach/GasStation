<!-- form-error.blade.php -->
@if ($errors->any())
    <section class="error">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="notification is-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif