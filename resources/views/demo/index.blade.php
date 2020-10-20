@role('writer')
I am a writer!
@else
    I am not a writer...
    @endrole

    ------------------------

    @hasrole('writer')
    I am a writer!
    @else
        I am not a writer...
        @endhasrole

        ------------------------

        @can('edit articles')
         I can edit articles
        @endcan