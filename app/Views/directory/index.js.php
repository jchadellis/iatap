<script>
    $(document).ready(() => {
        const table = $('.table').DataTable({
            columnDefs: [
            {
                targets: 0,
                render: function (data, type, row) {
                    if (type === 'sort') {
                        return data || '~'; // '~' is high in ASCII, pushes empty values to the bottom
                    }
                    return data;
                }
            }
        ],
            order: [[0, 'asc']]
        });
    })
</script>