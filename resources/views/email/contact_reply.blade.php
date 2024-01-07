@include('email.header')

<tr>
    <td align="center" bgcolor="#ffffff"
        style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
        <b>Hi {!! $first_name !!} {!! $last_name !!},</b>
        <br>
        <span>Admin sent you a reply from your contact form message.</span>
    </td>
</tr>

<tr>
    <td align="center" bgcolor="#f9f9f9"
        style="padding: 20px 20px 0 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px;">
        <p>
            <b>Message:</b> {!! $reply !!}
        </p>
    </td>
</tr>

@include('email.footer')
