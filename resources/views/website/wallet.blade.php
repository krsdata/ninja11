@extends('layouts.master') 
    @section('content') 


    <div class="app-container">
		 
		 @include('partial.navigation')
		
		<div class="content" style="padding-top:70px;">
			
			<div class="container wallet-card">
	<div class="myAccountContainer_3820a"><div><div class="block_7b092 totalBalanceRow_09c83"><div class="totalBalance_abb07"><label class="label_388a3">TOTAL BALANCE</label><div class="currency_03b72"><span><span class="d11-icon"><i class="fas fa-rupee-sign"></i> </span><span class="currency-amount">100</span></span></div></div><div><button class="new-button borderedButton_57ca9">ADD CASH</button></div></div><div class="block_7b092 depositedRow_7ce16"><div class="depositedBalance_c28d7"><div class="depositedBalance_c28d7"><label class="label_388a3">Deposited</label><span><span class="d11-icon"><i class="fas fa-rupee-sign"></i></span><span class="currency-amount">500</span></span></div><label class="label_388a3 withdrawNote_2e07e">This money cannot be withdrawn</label></div></div><div class="block_7b092 totalBalanceRow_09c83"><div class="depositedBalance_c28d7"><div class="depositedBalance_c28d7"><label class="label_388a3">Winnings</label><span><span class="d11-icon"><i class="fas fa-rupee-sign"></i></span><span class="currency-amount">1200</span></span></div><label class="label_388a3 withdrawNote_2e07e"><span>Minimum amount you can withdraw </span><span><span><span class="d11-icon"> <i class="fas fa-rupee-sign"></i></span><span class="currency-amount">200</span></span></span></label></div><div><div><button class="new-button borderedButton_57ca9 withdraw-btn">WITHDRAW</button></div></div></div><div class="block_7b092 noBorder_89eb8 depositedRow_7ce16"><div class="depositedBalance_c28d7"><div class="depositedBalance_c28d7"><label class="label_388a3">Bonus</label><span><span class="d11-icon"><i class="fas fa-rupee-sign"></i></span><span class="currency-amount">100</span></span></div><label class="label_388a3 withdrawNote_2e07e">Maximum usable cash bonus = 10% of entry</label></div></div></div></div>
	
	<div class="linksContainer_89747"><div><a href="" class="linkBlocks_4d175 transactionRow_04861"><label>My Transactions</label><div class="label_388a3 transactionIconContainer_7ce16"></div></a></div></div>
	
	</div>
			
		</div>
@stop