<form action='/registration' method="post">
@csrf
    <input required type="text" name="name" value="name">
    <input required type="email" name="email" value="email">
    <input required type="text" name="password" value="password">
    <button type="submit"> yes</button>
</form>
