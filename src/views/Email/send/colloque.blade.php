<!-- Bloc -->
<?php $width = isset($isEdit) ? 560 : 600; ?>

@if(isset($bloc->colloque))
    <table border="0" width="{{ $width }}" align="center" cellpadding="0" cellspacing="0" class="tableReset">
        <tr bgcolor="ffffff"><td height="35"></td></tr><!-- space -->
        <tr align="center" class="resetMarge">
            <td class="resetMarge">
                <!-- Bloc content-->
                <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                    <tr>
                        <td valign="top" width="375" class="resetMarge">
                            <h3 class="mainTitle" style="text-align: left;font-family: sans-serif;">{{ $bloc->colloque->titre }}</h3>
                            <p class="abstract">{!! $bloc->colloque->soustitre !!}</p>
                            <p>{{ $bloc->colloque->sujet }}</p>
                            <p><strong>Organisé par: </strong><cite>{{ $bloc->colloque->organisateur }}</cite></p>
                            <p><a target="_blank"
                                  style="padding: 5px 10px; text-decoration: none; background: {{ $campagne->newsletter->color }}; color: #fff; margin-top: 10px; display: inline-block;"
                                  href="{{ url('pubdroit/colloque/'.$bloc->colloque->id) }}">Informations et inscription</a></p>
                        </td>
                        <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                        <td align="center" valign="top" width="160" class="resetMarge">
                            <a target="_blank" href="{{ url('pubdroit/colloque/'.$bloc->colloque->id) }}">
                                <img width="130" border="0" alt="{{ $bloc->colloque->titre }}" src="{{ asset($bloc->colloque->frontend_illustration) }}" />
                            </a>
                        </td>
                    </tr>
                </table>
                <!-- Bloc content-->
            </td>
        </tr>
        <tr bgcolor="ffffff"><td height="35" class="blocBorder"></td></tr><!-- space -->
    </table>
    <!-- End bloc -->
@endif