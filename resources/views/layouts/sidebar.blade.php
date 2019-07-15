<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<div class="brand">
		<a href="{{ url('/') }}">
			<img src="{{ asset('images/brandimage.jpg') }}" class="" alt="{{ config('app.name', 'JU') }}">
		</a>
	</div>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<!-- Add icons to the links using the .nav-icon class
				with font-awesome or any other icon font library -->
				<li class="nav-item">
					<a href="{{ url('/home') }}" class="nav-link">
						<i class="nav-icon fa fa-dashboard"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>

				<li class="{{ \Request::is('order/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Order
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('order') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Orders</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('order.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Order</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('delivery/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Delivery
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('delivery') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Deliveries</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('delivery.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Delivery</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('bill/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Bill
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('bill') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Bills</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('bill.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Bill</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('sale-transaction/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Sale Transactions
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('sale-transaction') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Transactions</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('sale-transaction.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Transaction</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('purchase/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-gear"></i>
						<p>
							Purchase
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('purchase') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Purchases</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('purchase.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Purchase</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('purchase-transaction/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Purchase Transactions
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('purchase-transaction') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Transactions</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('purchase-transaction.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Transaction</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('expense/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-th"></i>
						<p>
							Expense
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('expense') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Expenses</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('expense.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Expense</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ url('expense-item') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Expense Items</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('expense-item.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add New Expense Item</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('production/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-gear"></i>
						<p>
							Production
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('production') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Productions</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('production.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Production</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('loan/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Loans
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('loan') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Loans</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('loan.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Loan</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('cc-loan/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-shopping-cart"></i>
						<p>
							CC Loan
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('cc-loan') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Loans</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('cc-loan.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Loan</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="{{ route('cc-loan-withdraw.index') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Withdraws</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('cc-loan-withdraw.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Withdraw</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('cc-loan-deposit.index') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Deposits</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('cc-loan-deposit.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Deposit</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('bank-account/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Bank Account
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('bank-account') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Accounts</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('bank-account.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add New Account</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('bank-transaction.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Transaction</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('glove/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Gloves
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('glove') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Gloves</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('glove.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Glove</p>
							</a>
						</li>
					</ul>
				</li>

{{-- 				<li class="{{ \Request::is('user/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Users
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('user') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Users</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('user.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add User</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('head-accounts/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Head Account
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('head-accounts') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Head Accounts</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('head-accounts.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add New</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('accounts/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Accounts
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('accounts') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Accounts</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('accounts.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add New</p>
							</a>
						</li>
					</ul>
				</li> --}}

				{{-- Product --}}

				<li class="{{ \Request::is('product/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-shopping-cart"></i>
						<p>
							Product
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('product') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Products</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('product.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Product</p>
							</a>
						</li>
					</ul>
				</li>
				
				{{-- Raw Materials --}}
				<li class="{{ \Request::is('raw-material/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-shopping-cart"></i>
						<p>
							Raw Material
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('raw-material') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Raw Materials</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('raw-material.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Create New</p>
							</a>
						</li>
					</ul>
				</li>

				{{-- House Rent --}}
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-shopping-cart"></i>
						<p>
							House Rent
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="{{ \Request::is('flat/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
							<a href="#" class="nav-link item">
								<i class="nav-icon fa fa-shopping-cart"></i>
								<p>
									Flat
									<i class="right fa fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="{{ url('flat') }}" class="nav-link">
										<i class="fa fa-circle-o nav-icon"></i>
										<p>Flats</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('flat.create') }}" class="nav-link">
										<i class="fa fa-circle-o nav-icon"></i>
										<p>Add New</p>
									</a>
								</li>
							</ul>
						</li>

						<li class="{{ \Request::is('house-rent/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
							<a href="#" class="nav-link item">
								<i class="nav-icon fa fa-shopping-cart"></i>
								<p>
									House Rent
									<i class="right fa fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="{{ url('house-rent') }}" class="nav-link">
										<i class="fa fa-circle-o nav-icon"></i>
										<p>Rents</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('house-rent.create') }}" class="nav-link">
										<i class="fa fa-circle-o nav-icon"></i>
										<p>Add Rent</p>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				
				{{-- Report --}}
				<li class="nav-item">
					<a href="{{ url('report') }}" class="{{ \Request::is('report/*') ? 'nav-link active' : 'nav-link'  }}">
						<i class="nav-icon fa fa-shopping-cart"></i>
						<p>
							Reports
						</p>
					</a>
				</li>

				<li class="{{ \Request::is('supplier/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-users"></i>
						<p>
							Supplier
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('supplier') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Suppliers</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('supplier.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Supplier</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="{{ \Request::is('customer/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-th"></i>
						<p>
							Customer
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('customer') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Customers</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('customer.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Customer</p>
							</a>
						</li>
					</ul>
				</li>

				{{-- <li class="{{ \Request::is('asset/*') ? 'nav-item has-treeview menu-open' : 'nav-item has-treeview'  }}">
					<a href="#" class="nav-link item">
						<i class="nav-icon fa fa-hdd-o"></i>
						<p>
							Asset
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ url('asset') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Assets</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('asset.create') }}" class="nav-link">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add New Asset</p>
							</a>
						</li>
					</ul>
				</li> --}}
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
