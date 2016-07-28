<!-- Bloc -->
<?php $width = isset($isEdit) ? 560 : 600; ?>
<table border="0" width="{{ $width }}" align="center" cellpadding="0" cellspacing="0" class="tableReset">
    <tr bgcolor="ffffff"><td height="35"></td></tr><!-- space -->
    <tr align="center" class="resetMarge">
        <td class="resetMarge">
            <!-- Bloc content-->
            <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                <tr>
                    <td valign="top" width="375" class="resetMarge">
                        <h3 class="mainTitle" style="text-align: left;font-family: sans-serif;">{{ $bloc->arret->reference }} du {{ $bloc->arret->pub_date->formatLocalized('%d %B %Y') }}</h3>
                        <p class="abstract">{!! $bloc->arret->abstract !!}</p>
                        <div>{!! $bloc->arret->pub_text !!}</div>
                        <p><a href="{{ asset(config('newsletter.path.arret').$bloc->arret->file) }}">Télécharger en pdf</a></p>
                    </td>
                    <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                    <td align="center" valign="top" width="160" class="resetMarge">
                       @if(!$bloc->arret->categories->isEmpty() )
                           @include('newsletter::Email.send.partials.categories',['categories' => $bloc->arret->categories])
                       @endif
                    </td>
                </tr>
            </table>
            <!-- Bloc content-->
        </td>
    </tr>
    @if($bloc->arret->analyses->isEmpty())
        <tr bgcolor="ffffff"><td height="35" class="blocBorder"></td></tr><!-- space -->
    @endif
    <tr>
        <td align="center">
            <!-- Analyses -->
            @include('newsletter::Email.send.partials.analyses', ['arret' => $bloc->arret, 'isEdit' => isset($isEdit) ? true : false])
            <!-- End Analyses -->
        </td>
    </tr>
    @if(!$bloc->arret->analyses->isEmpty())
        <tr bgcolor="ffffff"><td height="35" class="blocBorder"></td></tr><!-- space -->
    @endif
</table>
<!-- End bloc -->

