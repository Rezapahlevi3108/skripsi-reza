<form action="{{ route('perhitungan') }}" method="post">
    @csrf
    <input type="number" name="satu">
    <input type="number" name="dua">
    <button class="btn">submit</button>
</form>