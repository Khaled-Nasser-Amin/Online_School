
    <div class="card text-center">
        <div class="card-header">
            <h2>Confirm Your Email</h2>
            <h5>Dear {{$name}}</h5>
        </div>
        <div class="card-body">
            <p class="card-text">You need to Confirm Your Email to continue.</p>
            <form class="d-inline" method="get" action="{{route('ConfirmEmail')}}">
                @csrf
                <input class="btn btn-success" type="submit" value="Click here to confirm your account" >
            </form>

        </div>
    </div>



