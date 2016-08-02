
@if(!$arret->analyses->isEmpty())
    <!-- Bloc content-->
    <?php $width = isset($isEdit) ? 560 : 600; ?>
    <table border="0" width="{{ $width }}" align="center" cellpadding="0" cellspacing="0" class="resetTable">
        <tr bgcolor="ffffff"><td height="35"></td></tr><!-- space -->
        <tr align="center">

            <td class="resetMarge">
                <!-- Bloc content-->
                <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                    <tr>
                        <td valign="top" align="center" width="375" class="resetMarge contentForm">
                            <?php $i = 1; ?>
                            @foreach($arret->analyses as $analyse)
                                <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
                                    <tr>
                                        <td valign="top" width="375" class="resetMarge contentForm">
                                            <h3 style="text-align: left;font-family: sans-serif;">Analyse de l'arrêt {{ $arret->reference }}</h3>
                                            <!-- Authors -->
                                            @include('newsletter::Email.send.partials.authors')
                                            <!-- End Authors -->
                                            <p class="abstract">{!! $analyse->abstract !!}</p>
                                            <p><a href="{{ asset(config('newsletter.path.analyse').$analyse->file) }}">Télécharger en pdf</a></p>
                                        </td>
                                    </tr>
                                    @if( $arret->analyses->count() > 1 && $arret->analyses->count() > $i)
                                        <tr bgcolor="ffffff"><td colspan="3" height="35" class=""></td></tr><!-- space -->
                                    @endif
                                    <?php $i++; ?>
                                </table>
                            @endforeach
                        </td>
                        <td width="25" class="resetMarge"></td><!-- space -->
                        <td align="center" valign="top" width="160" class="resetMarge">
                            <a target="_blank" href="{{ config('newsletter.link.analyse') }}">
                                <?php $slug = $campagne->newsletter->site_id ? '/'.$campagne->newsletter->site->slug.'/' : ''; ?>
                                <img border="0" style="max-width: 130px;" alt="Analyses" src="{{ asset(config('newsletter.path.categorie').$slug.'analyse.jpg') }}">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- Bloc content-->
@endif