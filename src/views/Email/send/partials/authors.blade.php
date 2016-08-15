@if(!$analyse->authors->isEmpty())
    @foreach($analyse->authors as $author)
        <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" width="60" class="resetMarge">
                    <img style="width: 60px;" width="60" border="0" alt="{{ $author->name }}" src="{{ asset(config('newsletter.path.author').$author->author_photo) }}">
                </td>
                <td valign="top" width="10" class="resetMarge"></td>
                <td valign="top" width="305" class="resetMarge">
                    <h3 style="text-align: left;font-family: sans-serif;">{{ $author->name }}</h3>
                    <p style="font-family: sans-serif;">{{  $author->occupation }}</p>
                </td>
            </tr>
            <tr bgcolor="ffffff"><td colspan="3" height="15" class=""></td></tr><!-- space -->
        </table>
    @endforeach
@endif