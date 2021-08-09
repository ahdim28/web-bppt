@extends('mailing.template')

@section('content')
<tr>
    <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#0084ff; padding-bottom:30px;">
        @lang('mod/user.profile.verification.caption')
    </td>
</tr>
<tr>
    <th class="column-top" width="280" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="text pb20" style="color:#737373; font-family:'Ubuntu', Arial,sans-serif; font-size:16px; line-height:28px; text-align:center; padding-bottom:20px;">
                                @lang('mod/user.profile.verification.activate_mail') (<strong>{{ $data['email'] }}</strong>) @lang('mod/user.profile.verification.get_notification')
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </th>
</tr>
<!-- Button -->
<tr>
    <td align="center">
        <table width="120" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="text-button" style="background:#ec1c24 ; color:#ffffff; font-family:'Fira Mono', Arial,sans-serif; font-size:14px; line-height:18px; text-align:center; padding:12px;">
                    <a href="{{ $data['link'] }}" target="_blank" class="link-white" style="color:#ffffff; text-decoration:none;">
                        <span class="link-white" style="color:#ffffff; text-decoration:none;">
                            @lang('mod/user.profile.verification.btn_activate')
                        </span>
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- END Button -->
@endsection
