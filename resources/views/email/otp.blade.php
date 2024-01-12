@include('email.header')

<tr>
    <td align="center" bgcolor="#ffffff"
        style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
        <b>Hi {{ $user->firstname .' '.  $user->lastname }},</b>
        <br>
        <span>Thanks for signing up to Calcium & Joyjoy.</span>
    </td>
</tr>

<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
        <p>
            <b>Your OTP is:</b>
        </p>
        <h1>{{ $otp }}</h1>
        <p>Click here to verify your account: <a href="http://www.calciumandjoyjoy.store/otp/{{ $otp }}" target="_blank">http://www.calciumandjoyjoy.store/otp/{{ $otp }}</a></p>
    </td>
</tr>

@include('email.footer')
