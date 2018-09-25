<ul class="nav nav-tabs">
    <li class="nav-item">
        <a id="viewAllSalesTab" class="nav-link" href="/sales">All Sales</a>
    </li>

    <li class="nav-item">
        {{ link_to('/sales/daily/' . date('Y-m-d'), $title = 'Daily', $attributes = ['class' => 'nav-link', 'id'=>'dailySalesTab'], $secure = null) }}
    </li>

    <li class="nav-item">
        {{ link_to('/sales/monthly/' . date('Y-m'), $title = 'Monthly', $attributes = ['class' => 'nav-link', 'id'=>'monthlySalesTab'], $secure = null) }}
    </li>
</ul>

<script>
    $(document).ready(function (){
        // console.log(window.location.pathname.includes('sal'));
        if(window.location.pathname.includes('sale')){
            $('#viewAllSalesTab').addClass('active');
        }
        
        if(window.location.pathname.includes('daily')){
            $('#dailySalesTab').addClass('active');
            $('#viewAllSalesTab').removeClass('active');
        }
        
        if(window.location.pathname.includes('monthly')){
            $('#monthlySalesTab').addClass('active');
            $('#viewAllSalesTab').removeClass('active');
        }
    });
</script>