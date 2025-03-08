@extends("layouts.master")
@section('head')
<title>Bangabasi | Terms of Use</title>
@endsection
@section('content')
@php
    $xpage = 'Terms of Use';
    $xprv = 'home';
	use Carbon\Carbon;
@endphp
<x-bread-crumb :page="$xpage" :previousHref="$xprv" />
<style>
  .cursor::after {
    content: "|";
    display: inline-block;
    margin-left: 2px;
    animation: blink 0.7s step-end infinite;
  }

  @keyframes blink {
    from, to {
      opacity: 1;
    }
    50% {
      opacity: 0;
    }
  }
</style>
<section class="min-h-screen bg-neutral-50 my-8">
	<div class="container grid grid-cols-12 gap-4 py-8">
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Refund & Cancellation Policy</h2>
				<p class="typewriter" data-text="BANGABASI will not be responsible for any refunds arising out of any failures in online payments and in case the amount gets deducted from users saving/current account and does not get credited in BANGABASI account, before the transaction is complete. Users in this case will have to contact his Bank to clarify the same. Company reserves the right to modify and amend refund policy at its sole discretion. BANGABASI reserve the right to cancel ORDERS at anytime. In the event that BANGABASI cancels a scheduled ORDER, the USER will receive a full AMOUNT refund for the same. All refunds will be processed within 30 days of receipt of a valid refund request. In the event that BANGABASI cancels a ORDER, the full amount will be refunded. No ORDERS will be final and confirmed until the full amount is paid either by credit card /debit card /net banking / online payment or COD."></p>
			</div>
		</div>
		<div class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Return Policy</h2>
				<p class="typewriter" data-text="Returns is a scheme provided by respective sellers directly under this policy in terms of which the option of exchange, replacement and/ or refund is offered by the respective sellers to you. All products listed under a particular category may not have the same returns policy. For all products, the returns/replacement policy provided on the product page shall prevail over the general returns policy. Do refer the respective item's applicable return/replacement policy on the product page for any exceptions to this returns policy and the table below."></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Terms & Conditions</h2>
				<p class="typewriter" data-text="This official website of the 'BANGABASI' has been developed to provide information to the general public. The documents and information displayed in this website are for reference purposes only and does not purport to be a legal document.Bangabasi does not warrant the accuracy or completeness of the information, text, graphics, links or other items contained within the Website. As a result of updates and corrections, the web contents are subject to change without any notice from 'BANGABASI' at Bangabasi website.In case of any variance between what has been stated and that contained in the relevant Act, Rules, Regulations, Policy Statements etc, the latter shall prevail.Any specific advice or replies to queries in any part of the website is/are the personal views / opinion of such experts/consultants/persons and are not necessarily subscribed to by this Department or its websites.Certain links on the website lead to resources located on other websites maintained by third parties over whom Bangabasi has no control or connection. These websites are external to Bangabasi and by visiting these; you are outside the Bangabasi website and its channels. Bangabasi neither endorses in any way nor offers any judgment or warranty and accepts no responsibility or liability for the authenticity, availability of any of the goods or services or for any damage, loss or harm, direct or consequential or any violation of local or international laws that may be incurred by your visiting and transacting on these websites."></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Privacy Policy</h2>
				<p class="typewriter" data-text="The issue of online privacy is extremely crucial for bangabasi.com (BANGABASI), which is committed to safeguarding the information provided by its members and other visitors logging on to its Web site.Respecting the privacy of its online visitors, while providing quality services to customers has remained the core of BANGABASI’s overall strategy. Our Privacy Policy gives visitors a view of the Privacy Practices followed by BANGABASI and assures them of safe passage through the organisation’s website.At the same time, BANGABASI would like to make it clear that its site provides links to other Web sites that are governed by their own respective Privacy Policies and BANGABASI does not take responsibility for the security provided by these sites. Visitors to the BANGABASI website are urged to familiarize themselves with its Privacy Policy as well the policies of the sites linked to their website.When you provide us with your personal data, you are agreeing to the rules and regulations stipulated under our Privacy Policy and are bound by it. If you do not agree to our Policy please do not use the Website."></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">The Privacy Policy covers the following areas :</h2>
				<p class="typewriter font-semibold" data-text="Type of information collected through the Web site  Personal Information: "></p>
				<p class="typewriter ml-8" data-text="Users registering at the BANGABASI site for specific services are requested to provide some personally identifiable information which become the property of BANGABASI and can be shared, disclosed or distributed to third parties only in accordance with the Privacy Policy. Please take note that registration is not required for visitors to the site who do not require any specific services BANGABASI will not sell or rent such personally identifiable information collected. The personally identifiable information is supplied voluntarily for some of the following purposes:"></p>
  				<p class="typewriter ml-16" data-text="Registration Data - If you are merely a visitor to our site, BANGABASI does not collect any personal information about you, except to the limited extent through the use of cookies, as described below. If you decide to use certain services offered on the site, you will be asked to register. During registration you will be requested to complete a registration form setting out basic online contact information about yourself."></p>
  				<p class="typewriter ml-16" data-text="Other Optional Information: If you wish to subscribe to BANGABASI publications, newsletters, etc., you will be required to fill up certain personal information related to your email address, name, country, age, choice of password, etc. However, for any of the other services such as registration for membership, etc. filling up the relevant form is mandatory."></p>
				<p class="typewriter ml-16" data-text="Credit Card Information: If you purchase BANGABASI publications at the Site or register for an event, you will be required to submit your credit card details, including your name, account number and the expiration date. The information is used for billing purposes and to contact you if there are difficulties in processing your order. BANGABASI uses / will use a credit card processing company to bill users for goods and services which will not retain, share, store or use personally identifiable information for any secondary purposes."></p>
				<p class="typewriter ml-16" data-text="E-mail Information: When we receive e-mails from you, we may retain the content of any e-mail messages sent to us, as well as details of your e-mail address."></p>
				<p class="typewriter font-semibold" data-text="Use of web-based tracking mechanisms such as Cookies: "></p>	
				<p class="typewriter ml-4" data-text="Cookies, which enable us to store small amounts of information contained in your Web site browser, may be used on some areas of our Website. Cookies, that help us track your navigation, enable us to tailor our offerings to your needs. The kind of information that may be stored on a cookie includes registration data so that a user does not need to re-enter the information every time he/she visits a particular area. The information contained on cookies is masked to ensure your privacy and is readable only by the servers of BANGABASI. Third party Websites which are accessible from our Site via links, click-throughs or banner advertising may use Cookies. However, it is important for us to inform you that we have no access or control over such Cookies and do not accept responsibility with regards to them."></p>
  				<p class="typewriter" data-text="Choice/opt out: BANGABASI gives you the choice regarding the collection and usage of your personally identifiable information. During registration for “joining our mailing list,” we request for contact information in order to send bulletins and for advertising purposes. Again, it is not necessary for you to register in order to access and use our Site. You may therefore choose to opt out of providing such information. Further, once you are registered at the BANGABASI’s site, you will have the option at any stage to inform us that you no longer wish to receive future e-mails and you may “unsubscribe.”"></p>
			</div>
		</div>
		<div  class="font-mono leading-relaxed col-span-12 lg:col-span-12">
			<div class="max-w-3xl px-8 py-4 mx-auto bg-slte-100 shadow-md my-4">
				<h2 class=" text-3xl font-semibold my-4">Security</h2>
				<p class="typewriter" data-text="Access to your personal account online is password protected. We will not release your account password to any person. In the event that you forget your password, you may generate an on-line request for your password to be sent to you by e-mail at the e-mail address used during registration. BANGABASI has implemented stringent, internationally acceptable standards of technology and operational security in order to protect personally identifiable information from loss, misuse, alteration or destruction. The access to the data on the server is restricted to authorized BANGABASI personnel. BANGABASI cannot be held responsible for any activity in your account which results from your failure to keep your own password secure. For questions regarding the privacy statement, practices of the site, or any other transaction issue, please contact."></p>
			</div>
		</div>
	</div>
</section>
@endsection
@push('scripts')
<script>
	function typewriter(element, text, speed = 1000, callback) {
		let index = 0;

		function type() {
			if (index < text.length) {
				const char = text[index];
				element.innerHTML += char === '\n' ? '<br>' : char;
				index++;
				setTimeout(type, speed);
			} else if (callback) {
				element.classList.remove('cursor');
				callback(); // Trigger the next animation
			}
		}

		type();
	}

	function startSequentialTypewriter(selector, speed = 1000) {
		const elements = document.querySelectorAll(selector);
		let currentIndex = 0;

		function startNext() {
			if (currentIndex < elements.length) {
				const element = elements[currentIndex];
				element.classList.add('cursor');
				const text = element.dataset.text || '';
				typewriter(element, text, speed, startNext); // Call recursively for the next animation
				currentIndex++;
			}
		}

		startNext();
	}

	// Trigger the typewriter animations sequentially
	startSequentialTypewriter('.typewriter', 1000);
</script>
@endpush