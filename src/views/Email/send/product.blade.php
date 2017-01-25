<!-- Bloc -->
<?php $width = isset($isEdit) ? 560 : 600; ?>

@if(isset($bloc->product))
    <table border="0" width="{{ $width }}" align="center" cellpadding="0" cellspacing="0" class="tableReset">
        <tr bgcolor="ffffff"><td height="35"></td></tr><!-- space -->
        <tr align="center" class="resetMarge">
            <td class="resetMarge">
                <!-- Bloc content-->
                <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                    <tr>
                        <td valign="top" width="375" class="resetMarge">
                            <h3 class="mainTitle" style="text-align: left;font-family: sans-serif;">{{ $bloc->product->title }}</h3>
                            <p class="abstract">{!!$bloc->product->teaser !!}</p>
                            <div>{!! $bloc->product->description !!}</div>
                            <p><a target="_blank"
                                  style="padding: 5px 15px; text-decoration: none; background: {{ $campagne->newsletter->color }}; color: #fff; margin-top: 10px; display: inline-block;"
                                  href="{{ url('pubdroit/product/'.$bloc->product->id) }}">Acheter</a>
                            </p>
                        </td>
                        <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                        <td align="center" valign="top" width="160" class="resetMarge">
                            <a target="_blank" href="{{ url('pubdroit/product/'.$bloc->product->id) }}">
                                <img width="130" border="0" alt="{{ $bloc->product->title }}" src="{{ asset('files/products/'.$bloc->product->image) }}" />
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