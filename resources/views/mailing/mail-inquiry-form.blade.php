@extends('mailing.template')

@section('content')
<tr>
    <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#0084ff; padding-bottom:30px;">
        New Message from inquiry {!! $data['title'] !!}.
    </td>
</tr>
<tr>
    <th class="column-top" width="280" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:top;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="text pb20" style="color:#737373; font-family:'Ubuntu', Arial,sans-serif; font-size:16px; line-height:28px; text-align:left; padding-bottom:20px;">
                                <table width="100%" border="1" style=" border-collapse: collapse;">
                                    @foreach ($data['request'] as $key => $value)
                                    @if ($key != '_token' && $key != 'g-recaptcha-response' && $key != 'juk')    
                                    <tr>
                                        <th style="width: 200px;">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                        <td>
                                            @if ($key == 'jenis_usaha_koperasi')
                                            {{ $data['product'] }}
                                            @else
                                            {{ $value != null ? $value : '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>
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
                    <a href="mailto:{{ $data['request']['email'] }}?subject={{ $data['inquiry']->fieldLang('name') }}" target="_blank" class="link-white" style="color:#ffffff; text-decoration:none;">
                        <span class="link-white" style="color:#ffffff; text-decoration:none;">
                        Reply
                        </span>
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- END Button -->
@endsection
