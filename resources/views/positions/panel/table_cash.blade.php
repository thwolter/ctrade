<div class="u-heading-v3-1 g-mb-40">
    <h2 class="h3 u-heading-v3__title">Aktien</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover positions-table">
        <thead>
        <tr>
            <th>Nr</th>
            <th>Position</th>
            <th class="text-right">Gesamt</th>
        </tr>
        </thead>
        <tbody>
        <tr class="">
            <td class="align-middle">1</td>
            <td class="align-middle">Cash</td>
            <td class="text-right">{{ $portfolio->present()->cash() }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>

</div>

