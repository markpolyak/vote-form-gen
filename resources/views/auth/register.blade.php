<html>
<style type="text/css">
#container {
		width: 700px;
		margin: auto;
   }
</style>

<div id="container">
<form method="POST" action="/auth/register">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div>
  id_owner
  <input type="text" name="id_owner" value="{{ old('id_owner') }}">
  </div>
  <div>
  id_premise
  <input type="text" name="id_premise" value="{{ old('id_premise') }}">
  </div>
  <div>
  login
  <input type="text" name="login" value="{{ old('login') }}">
  </div>
  <div>
   password
  <input type="password" name="password">
  </div>
  <div>
  is_admin
  <input type="text" name="admin">
  </div>
  <div>
  status
  <input type="text" name="status">
  </div>
  <div>
  surname
  <input type="text" name="surname" value="{{ old('surname') }}">
  </div>
  <div>
  name
  <input type="text" name="name" value="{{ old('name') }}">
  </div>
  <div>
  patronymic
  <input type="text" name="patronymic" value="{{ old('  patronymic') }}">
  <!--дописать это дерьмо-->
  </div>
  <div>
  email
  <input type="email" name="email">
  </div>
  <div>
  phone
  <input type="text" name="phone">
  </div>
  <div>
    Confirm Password
    <input type="password" name="password_confirmation">
  </div>
  <div>
    <button type="submit">Register</button>
  </div>
</form>
</div>
</html>