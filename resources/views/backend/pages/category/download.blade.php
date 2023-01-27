<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>SubCategory</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subcategory as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->subcat_name }}</td>
            <td>{{ $invoice->category->cat_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
