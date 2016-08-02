<?php $width = isset($isEdit) ? 560 : 600; ?>
<table border="0" width="{{ $width }}" align="center" cellpadding="0" cellspacing="0" class="resetTable">
    <tr bgcolor="ffffff" class="blocBorder">
        <td>
            <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                <tr bgcolor="ffffff"><td height="15"></td></tr><!-- space -->
                <tr>
                    <td width="400" align="left" class="resetMarge contentForm" valign="top">
                        <h3 class="mainTitle" style="text-align: left;font-family: sans-serif;">{{ $bloc->groupe->categorie->title }}</h3>
                    </td>
                    <td width="160" align="center" valign="top" class="resetMarge">
                        <img width="130" border="0" src="{{ asset(config('newsletter.path.categorie').$bloc->groupe->categorie->image) }}" alt="{{ $bloc->groupe->categorie->title }}" />
                    </td>
                </tr><!-- space -->
                <tr bgcolor="ffffff"><td height="15"></td></tr><!-- space -->
            </table>
        </td>
    </tr><!-- space -->
</table>