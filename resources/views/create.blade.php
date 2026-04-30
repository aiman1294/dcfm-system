<form method="POST" action="/cases">
    @csrf
    <input name="case_title" placeholder="Case title">
    <button type="submit">Save</button>
</form>