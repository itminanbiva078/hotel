
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Voucher No </th>
            <th> Branch</th>
            <th> Store</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Batch</th>
            <th class="text-right color1">Return Qty</th>
            <th class="text-right color1">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $sin=0;
        $sout=0;
        $tbalance=0;
        @endphp
        @foreach($reports as $key => $report)
           

            <tr>
                <td>{{$key+1}}</td>
                <td>{{$report->date ?? ''}}</td>
                <td >{{$report->tvoucher ?? ''}}</td>
                <td >{{$report->branchName ?? ''}}</td>
                <td >{{$report->storeName ?? ''}}</td>
                <td >{{$report->customerName ?? ''}}</td>
                <td >{{$report->productName ?? ''}}</td>
                <td >{{$report->batchName ?? ''}}</td>
                    <td class="color3 text-right">
                        {{$report->quantity ?? ''}}
                        @php 
                        $sin+=$report->quantity;
                        @endphp
                    </td>
              <td class="text-right color1">{{helper::pricePrint($sin)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8" class="text-right">Grand-Total: </td>
            <td class="text-right color1">{{helper::pricePrint($sin)}}</td>
            <td class="text-right color1">{{helper::pricePrint($sin)}}</td>
        </tr>
    </tfoot>
</table>