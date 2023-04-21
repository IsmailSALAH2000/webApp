<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <title>signin</title>


<main>
  <form method="post">
    
  <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?= implode("<br>",$errors)?>
        </div>
    <?php endif; ?>


    <h1>Please Login</h1>

    <div>
      <input type="text" name="login" id="floatingInput" placeholder="Login">
      <label for="floatingInput">login</label>
    </div>
    <div>
      <input type="password" name="mdpHash" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div>
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button name="submit" type="submit">Login</button>
    
  </form>
</main>


    
  </body>
</html>
