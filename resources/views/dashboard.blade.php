<br>
token : {{ session('sso_token')}}
<br>

dashboad MOKE
<a href="{{ route('sso.callback', [
    'target' => env('SSO_CLIENT_MOKA'),
    'token' => session('sso_token')
]) }}" 
   class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    Login ke MOKA
</a>


@if(Auth::check() && request()->has('target'))
<script>
    window.location.href = "{{ route('sso.callback', ['target' => request('target')]) }}";
</script>
@endif
