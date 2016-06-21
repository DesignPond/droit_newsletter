<tr>
    <td width="600" align="center" valign="top">

        <!-- Logos and header img -->
        <table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="tableReset">
            <tr class="resetMarge" style="display:block;">
                <td width="600" style="margin: 0;padding: 0;display:block;border: 1px solid #ededed; border-bottom: 0;line-height: 0;">
                    <a href="{{ url('/') }}">
                        <?php
                            if($campagne->newsletter->banniere_logos &&  \File::exists($campagne->newsletter->banniere_logos)){
                                list($width, $height) = getimagesize(public_path($campagne->newsletter->banniere_logos));
                            }
                        ?>
                        <img width="{{ $width or '560' }}" height="{{ $height or '100' }}" style="display:block;margin: 0;padding: 0;" alt="{{ $campagne->newsletter->from_name }}" src="{{ asset($campagne->newsletter->banniere_logos ) }}" />
                    </a>
                </td>
            </tr>
            <tr class="resetMarge" style="display:block;">
                <td width="600" class="resetMarge" style="margin: 0;padding: 0;display:block;border: 0; line-height: 0;">
                    <?php
                        if($campagne->newsletter->banniere_header && \File::exists($campagne->newsletter->banniere_header)){
                            list($width, $height) = getimagesize(public_path($campagne->newsletter->banniere_header));
                        }
                    ?>
                    <img width="{{ $width or '560' }}" height="{{ $height or '100'  }}" alt="{{ $campagne->newsletter->from_name }}" src="{{ asset($campagne->newsletter->banniere_header ) }}" />
                </td>
            </tr>
        </table>
        <!-- End logos and header img -->

    </td>
</tr>
