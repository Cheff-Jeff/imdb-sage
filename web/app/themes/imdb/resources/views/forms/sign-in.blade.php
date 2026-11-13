<form action="{{ route('sign-in.post') }}" method="post">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" required />

  <label for="password">Password</label>
  <input type="password" id="password" name="password" required />

  <button type="submit">Sign in</button>
</form>
