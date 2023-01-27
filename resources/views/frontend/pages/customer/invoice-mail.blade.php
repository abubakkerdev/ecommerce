

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>A simple, clean, and responsive HTML invoice template</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}
            .space {
                height: 20px;
            }
			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
        <div class="space"></div>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="5">
						<table>
							<tr>
								<td class="title">
									<img src="https://i.postimg.cc/d38ZxVMS/Valorant-logo-svg.png" alt="Company logo" style="width: 100%; max-width: 300px" />
								</td>

								<td>
									Invoice #: {{ $billing_info->order_id }}<br />
									Created: {{ $order_info->created_at->format("F j, Y") }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="5">
						<table>
							<tr>
								<td width="160">
									{{ $billing_info->address }}
								</td>

								<td>
									{{ $billing_info->company ? $billing_info->company : NULL }}.<br />
									{{ $billing_info->name }}<br />
									{{ $user_info->email }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Payment Method</td>

					<td colspan="4">
                        @if ($order_info->payment_method == 1)
                            COD #
                        @elseif ($order_info->payment_method == 2)
                            SSL #
                        @else
                            Stripe #
                        @endif
                    </td>
				</tr>

				<tr class="details">
					<td>
                        @if ($order_info->payment_method == 1)
                            COD
                        @elseif ($order_info->payment_method == 2)
                            SSL
                        @else
                            Stripe
                        @endif
                    </td>

					<td colspan="4">${{ $order_info->total }}</td>
				</tr>

				<tr class="heading">
					<td>Item</td>
                    <td style="width: 40%"></td>
					<td style="padding-left: 10%">Price</td>
					<td style="padding-left: 12%">Quantity</td>
					<td style="padding-left: 15%">Total</td>
				</tr>

                @foreach ($product_info as $key => $product)
                    <tr class="item {{ ($product->id == $product_lastId->id) ? 'last' : NULL }}">
                        <td>{{ $product->product_name }}</td>

                        <td style="width: 40%"></td>
                        <td style="padding-left: 10%">{{ $product->product_price }}</td>
                        <td style="padding-left: 13%; width: 4%">{{ $product->product_quantity }}</td>
                        <td style="padding-left: 15%">${{ $product->product_price*$product->product_quantity }}</td>
                    </tr>
                @endforeach



				<tr class="total">
					<td colspan="4">
                        @php
                            $price = [0,1000,5000,10000];
                            $vat_charge = [10,20,30];

                            foreach ($price as $key => $range)
                            {
								if (count($price)-1 > $key)
								{
									if (App\Models\Frontend\Order::where('id', $billing_info->order_id)->whereBetween('total', [$price[$key], $price[$key+1]])->exists())
									{
										if ($order_info->total > $price[$key] && $order_info->total <= $price[$key+1])
										{
											$total_vat = $vat_charge[$key];
										}
									}
								}
                            }

                            $total_p = ($order_info->total-$order_info->delivery_charge);

                            $grand_total = $total_p + ($total_p*$total_vat/100) + $order_info->delivery_charge;

                        @endphp
                    </td>

					<td>Delivery Charge: ${{ $order_info->delivery_charge }} <br>
					    Vat: {{ $total_vat }}% <br>
                        Grand-total: ${{ $grand_total }}
                    </td>
				</tr>

			</table>
		</div>
	</body>
</html>

