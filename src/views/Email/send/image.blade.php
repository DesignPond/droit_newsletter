<!-- Bloc -->
<table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="tableReset">
    <tr bgcolor="ffffff"><td colspan="3" height="35"></td></tr><!-- space -->
    <tr align="center" class="resetMarge">
        <td class="resetMarge">
            <!-- Bloc content-->
            <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                <tr>
                    <td align="center" valign="top" width="560" class="resetMarge">
                        <p class="centerText">
                            <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->link_or_url : url('/') }}">
                                <img style="max-width: 560px;" alt="{{ $bloc->titre or '' }}" src="{{ asset(config('newsletter.path.upload').$bloc->image) }}" />
                            </a>
                        </p>
                    </td>
                </tr>
                <tr bgcolor="ffffff">
                    <td align="center" valign="top" width="560" class="resetMarge">
                        @if( $bloc->titre )
                            <h2 class="centerText">{{ $bloc->titre }}</h2>
                        @endif
                    </td>
                </tr><!-- space -->
            </table>
            <!-- Bloc content-->
        </td>
    </tr>
    <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
</table>
<!-- End bloc -->

