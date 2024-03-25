
<div class="content-wrapper">
   
    <section class="content">
      
        <!-- Manage Supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('supplier_list') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table  border="1" width="100%" style="margin-top:25px;border-collapse:collapse;">
                                 <caption style="text-align: center;">
                               {company_info}
                                     <address style="margin-top:10px">
                                        <strong style="font-size: 20px; ">{company_name}</strong><br>
                                        {address}<br>
                                        <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
                                        <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                        {email}<br>
                                        <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                        {website}
                                    </address>

                               {/company_info}
                           </caption>
                                <thead>
                                    <tr>
                                        <!--<th>id</th>-->
                                        <th><?php echo display('supplier_id') ?></th>
                                        <th><?php echo display('supplier_name') ?></th>
                                        <th><?php echo display('address') ?></th>
                                        <th><?php echo display('mobile') ?></th>
                                         <th><?php echo display('balance') ?></th> 
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    echo '<pre>'; print_r($suppliers_list);echo '</pre>';
                                    if ($supplier_list) {
                                        $total_balance=0;
                                        foreach ($supplier_list as $supplier) {
                                            ?>
                                            <tr>
                                                <!--<td><?php echo $supplier['id']; ?></td>-->
                                                <td><?php echo $supplier['supplier_id']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url() . 'Csupplier/supplier_ledger_info/'.$supplier['supplier_id']; ?>">
                                                        <?php echo $supplier['supplier_name']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $supplier['address']; ?></td>
                                                <td><?php echo $supplier['mobile']; ?></td>
                                                 <td class="text-right"><?php 
                                       $debit = $this->db->select('SUM(amount) as total_debit')->from('supplier_ledger')->where('supplier_id',$supplier['supplier_id'])->where('d_c','d')->get()->row();    
                                       $credit = $this->db->select('SUM(amount) as total_credit')->from('supplier_ledger')->where('supplier_id',$supplier['supplier_id'])->where('d_c','c')->get()->row();
                                        $balance = $debit->total_debit - $credit->total_credit;
                                        if($position == 0){
                                                       echo   $currency.' '.number_format($balance, 2, '.', ',');  
                                                        }else{
                                                echo  number_format($balance, 2, '.', ',').''.$currency;
                                                        }
                                       
                                       $total_balance += $balance;
                                                
                                                ?></td> 
                                            <?php }} ?>
                                            </tr>
                                               
                                </tbody>
                             <!--   <tfooter>
                                    <tr><td colspan="4" class="text-right"><b><?php echo display('total')?></b></td><td class="text-right"><?php 
                                    
                                                       echo $total_balance;  
                                                        
                                    ?></td></tr>
                                </tfooter>  -->

                            </table>
                            <!--<div class="text-center"><?php echo $links ?></div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
