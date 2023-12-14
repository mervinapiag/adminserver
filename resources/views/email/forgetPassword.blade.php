@include('email.header')

<tr>
    <td align="center" bgcolor="#ffffff"
        style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
        <b>Hi {{ $user->firstname .' '.  $user->lastname }},</b>
        <br>
        <span>Forget Password Email</span>
    </td>
</tr>

<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
        You can reset password from bellow link:
        <a href="http://www.calciumandjoyjoy.store/reset/{{ $token }}" target="_blank">Reset Password</a>
    </td>
</tr>

@include('email.footer')
