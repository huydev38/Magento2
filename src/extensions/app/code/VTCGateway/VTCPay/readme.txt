******************************************************
*		Company: 		<VTC INTECOM>											 
*  		Author:			<Nguyen Trong Phuong>		 
*  		Create date:	<05/10/2018>				 	
*  		Description:	<Magento Version 2.2.6>		 
*													 
******************************************************


các bước thực hiện cài đặt Plugin.

1. thực hiện cài đặt và chạy trên môi trường test
 b1. đăng nhập hệ thống http://alpha1.vtcpay.vn/wallet/trang-chu  bằng tài khoản:  0963465816/Aa@123456(thông tin tài khoản có thế xem tại: http://sandbox3.vtcebank.vn/VTCDocuments/TaiLieuTichHopWebSite_V2.html)
 b2. chọn tích hợp thanh toán -> tích hợp website -> thêm mới
 b3. điền các thông tin yêu cầu trên form. chú ý ô Url nhận kết quả điền link sau:    url trang chủ của bạn/vtcgatewayvtcpay/order/notification    ví dụ: https://www.vietnamvodich.vn/vtcgatewayvtcpay/order/notification 
 b4. copy file VTCGateway vào thư mục app/code nằm trên thư mục root web site của bạn. nếu trong app không có thư mục code thì bạn có thể tự tạo thử mục code
 b5. chạy các lệnh sau trên command line trên thư mục root website của bạn
	php bin/magento cache:clean   
	php bin/magento cache:flush
	php bin/magento module:upgrade  hoặc  php bin/magento setup:upgrade tùy theo phiên bản magento.
	php bin/magento setup:static-content:deploy
	php bin/magento indexer:reindex 
	
	kiểm tra xem plugin đã được cài thành công chưa bằng lệnh:
	php bin/magento module:status
	
	chú ý: khi thực hiện chạy các lệnh trên cache website của bạn sẽ bị xóa.
 b6. vào CMS Magento  chọn STORES -> Configuration - > Sales -> Payment Methods 
 b7. mở mục VTCPay Gateway điền các thông tin như trên Form yêu cầu Sau đó nhấn Save Config 
	chú ý:
	VTCPay Account: tài khoản vtcpay bạn đăng ký trên hệ thống vtcpay
	website ID: là id web site bạn tạo ở b1
	Secret Key: mã bảo mật bạn điền lúc tạo website id ở b1
	Test Mode: chọn Yes nếu bạn dùng chế độ kiểm thử, No nếu bạn muốn chạy Production. chú ý:   nếu bạn test thì bạn phải đăng ký tài khoản/website ID ở:  http://alpha1.vtcpay.vn/wallet/trang-chu  .   còn bạn chạy Prodution thì bạn đăng ký tài khoản/website ID ở: https://vtcpay.vn/ 
	New Order Status, Payment Success, Payment Failed, Payment Canceled, Payment Review, Payment Suspected Fraud: là các trạng thái Status hiển thị trên CMS khi khác hàng thực hiện thanh toán thành công. bạn cần thực hiện lựa chọn lại cho phù hợp với hệ thống hiện tại của bạn
	Language Use: ngôn ngữ hiển thị trên cổng thanh toán.
 b8. Save Config.
2. chuyển chạy trên môi trường Production
 b1. đăng nhập hệ thống https://vtcpay.vn/   bằng tài khoản bạn đăng kí trên https://vtcpay.vn
 b2. chọn tích hợp thanh toán -> tích hợp website -> thêm mới
 b3. điền các thông tin yêu cầu trên form. chú ý ô Url nhận kết quả điền link sau:    url trang chủ của bạn/vtcgatewayvtcpay/order/notification    ví dụ: https://www.vietnamvodich.vn/vtcgatewayvtcpay/order/notification 
 b4. b3. điền các thông tin yêu cầu trên form. chú ý ô Url nhận kết quả điền link sau:    url trang chủ của bạn/vtcgatewayvtcpay/order/notification    ví dụ: https://www.vietnamvodich.vn/vtcgatewayvtcpay/order/notification 
 b5. mở mục VTCPay Gateway điền các thông tin
	VTCPay Account: tài khoản vtcpay bạn đăng ký trên hệ thống vtcpay
	website ID: là id web site bạn tạo ở b1
	Secret Key: mã bảo mật bạn điền lúc tạo website id ở b1
	Test Mode: chọn NO
	New Order Status, Payment Success, Payment Failed, Payment Canceled, Payment Review, Payment Suspected Fraud: là các trạng thái Status hiển thị trên CMS khi khác hàng thực hiện thanh toán thành công. bạn cần thực hiện lựa chọn lại cho phù hợp với hệ thống hiện tại của bạn
 b6. Save Config.