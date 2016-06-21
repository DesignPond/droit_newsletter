<tr>
    <td align="center">
        <!-- Title -->
        <table bgcolor="{{ $campagne->newsletter->color }}" width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="resetTable headerInfos">
            <tr bgcolor="{{ $campagne->newsletter->color }}"><td colspan="4" height="10"></td></tr><!-- space -->
            <tr bgcolor="{{ $campagne->newsletter->color }}">
                <td width="430">
                    <table width="430" bgcolor="{{ $campagne->newsletter->color }}" border="0" cellpadding="0" cellspacing="0" align="center" class="resetTable">
                        <tr bgcolor="{{ $campagne->newsletter->color }}">
                            <td width="20"></td>
                            <td colspan="2" align="left"><h1 class="header"><span style="color: #fff;font-size: 18px;">{{ $campagne->sujet  }}</span></h1></td>
                            <td width="20"></td>
                        </tr>
                        <tr bgcolor="{{ $campagne->newsletter->color }}">
                            <td width="20"></td>
                            <td align="left"><h2 class="header headerSmall"><span style="color: #fff;font-size: 15px;">Editée par {{ $campagne->auteurs }}</span></h2></td>
                            <td width="20"></td>
                        </tr>
                    </table>
                </td>
                <td width="110" style="text-align: left; ">
                    @if($campagne->newsletter->logo_soutien)
                        <small style="text-align: left; font-family: sans-serif;color: #fff;font-size: 11px;">Avec le soutien de</small>
                        <a target="_blank" href="#">
                            <img style="max-width: 105px;" alt="soutien" src="{{ asset($campagne->newsletter->logo_soutien) }}" />
                        </a>
                    @endif
                </td>
            </tr><!-- space -->
            <tr bgcolor="{{ $campagne->newsletter->color }}"><td colspan="4" height="10"></td></tr><!-- space -->
        </table>
        <!-- End title -->
    </td>
</tr>