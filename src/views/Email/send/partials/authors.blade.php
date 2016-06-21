@if(!$analyse->analyse_authors->isEmpty())
    @foreach($analyse->analyse_authors as $analyse_authors)
        <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" width="60" class="resetMarge">
                    <img style="width: 60px;" width="60" border="0" alt="{{ $analyse_authors->name }}" src="{{ asset('authors/'.$analyse_authors->photo) }}">
                </td>
                <td valign="top" width="10" class="resetMarge"></td>
                <td valign="top" width="305" class="resetMarge">
                    <h3 style="text-align: left;font-family: sans-serif;">{{ $analyse_authors->name }}</h3>
                    <p style="text-align: left;font-family: sans-serif;">{{  $analyse_authors->occupation }}</p>
                </td>
            </tr>
            <tr bgcolor="ffffff"><td colspan="3" height="15" class=""></td></tr><!-- space -->
        </table>
    @endforeach
@endif