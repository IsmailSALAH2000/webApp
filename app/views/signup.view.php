<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <title>signin</title>

    
<main >
  <form method="post">

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?= implode("<br>",$errors)?>
        </div>
    <?php endif; ?>



    <h1>Please sign Up</h1>

    <div>
      <input type="text" name="login" id="floatingInput" placeholder="Login">
      <label for="floatingInput">Login</label>
    </div>
    <div>
      <input type="password" name="password" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div>
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button name="submit" type="submit">Sign up</button>
    
  </form>
</main>


    
  </body>
</html>
