<h4>Subscribe to news</h4>
<form action="/subscribe" method="post">
@csrf
    <input type="text" name="email" class="form-control">
    <input type="submit" name="subscribe" class="btn btn-success" value="Subscribe">
</form>
