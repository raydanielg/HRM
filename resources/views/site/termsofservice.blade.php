@extends("site.app")
@section("title")
    Terms of Service - {{ $setting->main_name }}
@endsection

@section("content")
    <section>
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <h2>Terms of Service</h2>

                <div class="row">
                    <div class="col-md-12">

                        THIS IS AN AGREEMENT BETWEEN YOU OR THE ENTITY THAT YOU REPRESENT (hereinafter "You" or "Your") AND {{$setting->main_name}} (hereinafter "{{$setting->main_name}}") GOVERNING YOUR USE OF TIME TRACKER SYSTEM – HRM (hereinafter the "Software").

<h4>1. Acceptance of Terms</h4>

This Agreement consists of the following terms and conditions referred to as the "Terms". You must be of legal age to enter into a binding agreement in order to accept the Terms. If you do not agree to the Terms, do not use the Software. You can accept the Terms by checking a checkbox or clicking on a button indicating your acceptance of the terms or by actually using the Software.

<h4>2. Description of Software</h4>

{{ $setting->main_name }}, an HR Management solution. You may use the Software for your personal and business use or for internal business purpose in the organization that you represent. You may connect to the Software using any Internet browser supported by the Software. You are responsible for obtaining access to the Internet and the equipment necessary to use the Software. You can create and edit content with your user account and if you choose to do so, you can publish and share such content.

<h4>3. Modification of Terms of Software</h4>

We may modify the Terms upon notice to you at any time through a service announcement or by sending email to your primary email address. If we make significant changes to the Terms that affect your rights, you will be provided with at least 30 days advance notice of the changes by email to your primary email address. You may terminate your use of the Software by providing {{$setting->main_name}} notice by email within 30 days of being notified of the availability of the modified Terms if the Terms are modified in a manner that substantially affects your rights in connection with use of the Software. In the event of such termination, you will be entitled to prorated refund of the unused portion of any prepaid fees. Your continued use of the Software after the effective date of any change to the Terms will be deemed to be your agreement to the modified Terms.

<h4>4. User Sign up Obligations</h4>

You need to sign up for a user account by providing all required information in order to access or use the Software. If you represent an organization and wish to use the Software for corporate internal use, we recommend that you, and all other users from your organization, sign up for user accounts by providing your corporate contact information. In particular, we recommend that you use your corporate email address. You agree to: a) provide true, accurate, current and complete information about yourself as prompted by the sign-up process; and b) maintain and promptly update the information provided during sign up to keep it true, accurate, current, and complete. If you provide any information that is untrue, inaccurate, outdated, or incomplete, or if {{$setting->main_name}} has reasonable grounds to suspect that such information is untrue, inaccurate, outdated, or incomplete, {{$setting->main_name}} may terminate your user account and refuse current or future use of the Software.

<h4>5. Organization Accounts and Administrators</h4>

When you sign up for an account for your organization you may specify one or more administrators. The administrators will have the right to configure the Software based on your requirements and manage end users in your organization account. If your organization account is created and configured on your behalf by a third party, it is likely that such third party has assumed administrator role for your organization. Make sure that you enter into a suitable agreement with such third party specifying such party’s roles and restrictions as an administrator of your organization account. You are responsible for:
<ol>
<li>ensuring confidentiality of your organization account password,</li>
<li>appointing competent individuals as administrators for managing your organization account, and</li>
<li>ensuring that all activities that occur in connection with your organization account comply with this Agreement. You understand that {{$setting->main_name}} is not responsible for account administration and internal management of the Software for you.</li>
</ol>
You are responsible for taking necessary steps for ensuring that your organization does not lose control of the administrator accounts. You may specify a process to be followed for recovering control in the event of such loss of control of the administrator accounts by sending an email to <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>, provided that the process is acceptable to {{$setting->main_name}}. In the absence of any specified administrator account recovery process, {{$setting->main_name}} may provide control of an administrator account to an individual providing proof satisfactory to {{$setting->main_name}} demonstrating authorization to act on behalf of the organization. You agree not to hold {{$setting->main_name}} liable for the consequences of any action taken by {{$setting->main_name}} in good faith in this regard.

<h4>6. Self-Hosted Terms</h4>

<h5>6.1 Your License Rights</h5>

Subject to the terms and conditions of this Agreement, {{$setting->main_name}} grants you a non-exclusive, non-sublicensable and non-transferable license to install and use the Software during the applicable License Term in accordance with this Agreement.

<h5>6.2 Number of Instances</h5>

Unless otherwise specified in your Order, for each Software license that you purchase, you may install one instance of the Software on systems owned or operated by you (or your third party service providers so long as you remain responsible for their compliance with the terms and conditions of this Agreement).

<h5>6.3 Your Modifications</h5>

Subject to the terms and conditions of this Agreement:

<ol>
<li>for any elements of the Software provided by {{$setting->main_name}} in source code form, and to the extent permitted in the Documentation, you may modify such source code solely for purposes of developing bug fixes, customizations and additional features for the Software and</li>

<li>you may also modify the Documentation to reflect your permitted modifications of the Software source code or the particular use of the Products within your organization.</li>
</ol>

Any modified source code or Documentation constitutes "Your Modifications". You may use Your Modifications solely with respect to your own instances in support of your permitted use of the Software but you may not distribute the code of Your Modifications to any third party. Notwithstanding anything in this Agreement to the contrary, {{$setting->main_name}} has no support, warranty, indemnification or other obligation or liability with respect to Your Modifications or their combination, interaction or use with our Products. You shall indemnify, defend and hold us harmless from and against any and all claims, costs, damages, losses, liabilities and expenses (including reasonable attorneys’ fees and costs) arising out of or in connection with any claim brought against us by a third party relating to Your Modifications (including but not limited to any representations or warranties you make about Your Modifications or the Software) or your breach of this Section 6.3. This indemnification obligation is subject to your receiving (i) prompt written notice of such claim (but in any event notice in sufficient time for you to respond without prejudice); (ii) the exclusive right to control and direct the investigation, defense, or settlement of such claim; and (iii) all reasonably necessary cooperation of {{$setting->main_name}} at your expense.

<h5>6.4 Attribution</h5>

In any use of the Software, you must include the following attribution to {{$setting->main_name}} on all user interfaces in the following format: "Powered by {{$setting->main_name}}" which must in every case include a hyperlink to http://www.solutionrack.com, and which must be in the same format as delivered in the Software. If no such attribution is delivered with the Software, it is not required to include such attribution.

<h5>6.5 Support</h5>

The support provided by {{$setting->main_name}} for self-hosted services is limited to the issues arising because of bugs in the Software delivered. It does not include (i) issues arising as a result of outdated software running on server on which you choose to install the Software (ii) issues arising as a result

of Your Modifications as described in section 6.5 (iii) issues arising because server not meeting System Requirements for the Software.

<h4>7. Personal Information and Privacy</h4>

Personal information you provide to {{$setting->main_name}} through the Software is governed by TIME TRACKER SYSTEM – HRM Privacy Policy. Your election to use the Software indicates your acceptance of the terms of the TIME TRACKER SYSTEM – HRM Privacy Policy. You are responsible for maintaining confidentiality of your username, password and other sensitive information. You are responsible for all activities that occur in your user account and you agree to inform us immediately of any unauthorized use of your user account by email to <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>. We are not responsible for any loss or damage to you or to any third party incurred as a result of any unauthorized access and/or use of your user account, or otherwise.

<h4>8. Communications from {{$setting->main_name}}</h4>

The Software may include certain communications from {{$setting->main_name}}, such as service announcements, administrative messages and newsletters. You understand that these communications shall be considered part of using the Software. As part of our policy to provide you total privacy, we also provide you the option of opting out from receiving newsletters from us. However, you will not be able to opt-out from receiving service announcements and administrative messages.

<h4>9. Complaints</h4>

If we receive a complaint from any person against you with respect to your activities as part of use of the Software, we will forward the complaint to the primary email address of your user account. You must respond to the complainant directly within 10 days of receiving the complaint forwarded by us and copy {{$setting->main_name}} in the communication. If you do not respond to the complainant within 10 days from the date of our email to you, we may disclose your name and contact information to the complainant for enabling the complainant to take legal action against you. You understand that your failure to respond to the forwarded complaint within the 10 days’ time limit will be construed as your consent to disclosure of your name and contact information by {{$setting->main_name}} to the complainant.

<h4>10. Fees and Payments</h4>

The Software is available under monthly subscription plan. Your subscription can be automatically renewed at the end of each month unless you downgrade your paid subscription plan to a free plan or inform us that you do not wish to renew the subscription. If you do not wish to renew the subscription, you must inform us at least seven days prior to the renewal date. If you have not downgraded to a free plan and if you have not informed us that you do not wish to renew the subscription, you will be presumed to have authorized {{$setting->main_name}} to charge the subscription fee. From time to time, we may change the price of any Software or charge for use of Services that are currently available free of charge. Any increase in charges will not apply until the expiry of your then current billing cycle. You will not be charged for using any Software unless you have opted for a paid subscription plan.

<h4>11. Restrictions on Use</h4>

In addition to all other terms and conditions of this Agreement, you shall not: (i) transfer the Software or otherwise make it available to any third party; (ii) provide any service based on the Software without prior written permission; (iii) use the third party links to sites without agreeing to their website terms & conditions; (iv) post links to third party sites or use their logo, company name, etc. without their prior written permission; (v) publish any personal or confidential information belonging to any person or entity without obtaining consent from such person or entity; (vi) use the Software in any manner that could damage, disable, overburden, impair or harm any server, network, computer system, resource of {{$setting->main_name}}; (vii) violate any applicable local, state, national or international law; and (viii) create a false identity to mislead any person as to the identity or origin of any communication.

<h4>12. Spamming and Illegal Activities</h4>

You agree to be solely responsible for the contents of your transmissions through the Software. You agree not to use the Software for illegal purposes or for the transmission of material that is unlawful, defamatory, harassing, libelous, invasive of another's privacy, abusive, threatening, harmful, vulgar, pornographic, obscene, or is otherwise objectionable, offends religious sentiments, promotes racism, contains viruses or malicious code, or that which infringes or may infringe intellectual property or other rights of another. You agree not to use the Software for the transmission of "junk mail", "spam", "chain letters", "phishing" or unsolicited mass distribution of email. We reserve the right to terminate your access to the Software if there are reasonable grounds to believe that you have used the Software for any illegal or unauthorized activity.

<h4>13. Inactive User Accounts Policy</h4>

We reserve the right to terminate unpaid user accounts that are inactive for a continuous period of 120 days. In the event of such termination, all data associated with such user account will be deleted. We will provide you prior notice of such termination and option to back-up your data. In case of accounts with more than one user, if at least one of the users is active, the account will not be considered inactive.

<h4>14. Data Ownership</h4>

We respect your right to ownership of content created or stored by you. You own the content created or stored by you. Unless specifically permitted by you, your use of the Software does not grant {{$setting->main_name}} the license to use, reproduce, adapt, modify, publish or distribute the content created by you or stored in your user account for {{$setting->main_name}}'s commercial, marketing or any similar purpose. But you grant {{$setting->main_name}} permission to access, copy, distribute, store, transmit, reformat, publicly display and publicly perform the content of your user account solely as required for the purpose of providing the Software to you.

<h4>15. User Generated Content</h4>

You may transmit or publish content created by you using the Software or otherwise. However, you shall be solely responsible for such content and the consequences of its transmission or publication. Any content made public will be publicly accessible through the internet and may be crawled and indexed by search engines. You are responsible for ensuring that you do not accidentally make any private content publicly available. Any content that you may receive from other users of the Software, is provided to you AS IS for your information and personal use only and you agree not to use, copy, reproduce, distribute, transmit, broadcast, display, sell, license or otherwise exploit such content for any purpose, without the express written consent of the person who owns the rights to such content. In the course of using the Software, if you come across any content with copyright notice(s) or any copy protection feature(s), you agree not to remove such copyright notice(s) or disable such copy protection feature(s) as the case may be. By making any copyrighted/copyrightable content available on the Software you affirm that you have the consent, authorization or permission, as the case may be from every person who may claim any rights in such content to make such content available in such manner. Further, by making any content available in the manner aforementioned, you expressly agree that {{$setting->main_name}} will have the right to block access to or remove such content made available by you if {{$setting->main_name}} receives complaints

concerning any illegality or infringement of third party rights in such content. By using the Software and transmitting or publishing any content using such Software, you expressly consent to determination of questions of illegality or infringement of third party rights in such content by the agent designated by {{$setting->main_name}} for this purpose.

<h4>16. Disclaimer of Warranties</h4>

YOU EXPRESSLY UNDERSTAND AND AGREE THAT THE USE OF THE SERVICE IS AT YOUR SOLE RISK. THE SERVICES ARE PROVIDED ON AN AS-IS-AND-AS-AVAILABLE BASIS. {{$setting->main_name}} EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. {{$setting->main_name}} MAKES NO WARRANTY THAT THE SERVICES WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR FREE. USE OF ANY MATERIAL DOWNLOADED OR OBTAINED THROUGH THE USE OF THE SERVICES SHALL BE AT YOUR OWN DISCRETION AND RISK AND YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR COMPUTER SYSTEM, MOBILE TELEPHONE, WIRELESS DEVICE OR DATA THAT RESULTS FROM THE USE OF THE SERVICE OR THE DOWNLOAD OF ANY SUCH MATERIAL. NO ADVICE OR INFORMATION, WHETHER WRITTEN OR ORAL, OBTAINED BY YOU FROM {{$setting->main_name}}, ITS EMPLOYEES OR REPRESENTATIVES SHALL CREATE ANY WARRANTY NOT EXPRESSLY STATED IN THE TERMS.

<h4>17. Limitation of Liability</h4>

YOU AGREE THAT {{$setting->main_name}} SHALL, IN NO EVENT, BE LIABLE FOR ANY CONSEQUENTIAL, INCIDENTAL, INDIRECT, SPECIAL, PUNITIVE, OR OTHER LOSS OR DAMAGE WHATSOEVER OR FOR LOSS OF BUSINESS PROFITS, BUSINESS INTERRUPTION, COMPUTER FAILURE, LOSS OF BUSINESS INFORMATION, OR OTHER LOSS ARISING OUT OF OR CAUSED BY YOUR USE OF OR INABILITY TO USE THE SERVICE, EVEN IF {{$setting->main_name}} HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. IN NO EVENT SHALL {{$setting->main_name}}'S ENTIRE LIABILITY TO YOU IN RESPECT OF THE SERVICE, WHETHER DIRECT OR INDIRECT, EXCEED THE FEES PAID BY YOU TOWARDS SUCH SERVICE.

<h4>18. Indemnification</h4>

You agree to indemnify and hold harmless {{$setting->main_name}}, its officers, directors, employees, suppliers, and affiliates, from and against any losses, damages, fines and expenses (including attorney's fees and costs) arising out of or relating to any claims that you have used the Software in violation of another party's rights, in violation of any law, in violations of any provisions of the Terms, or any other claim related to your use of the Software, except where such use is authorized by {{$setting->main_name}}.

<h4>19. Suspension and Termination</h4>

We may suspend your user account or temporarily disable access to whole or part of any Software in the event of any suspected illegal activity, extended periods of inactivity or requests by law enforcement or other government agencies. Objections to suspension or disabling of user accounts should be made to <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a> within thirty days of being notified about the suspension. We may terminate a suspended or disabled user account after thirty days. We will also terminate your user account on your request. In addition, we reserve the right to terminate your user account and deny the Software upon reasonable belief that you have violated the Terms. You have the right to terminate your user account if {{$setting->main_name}} breaches its obligations under these Terms and in such event, you will be entitled to prorated refund of

access to the Software, deletion of information in your user account such as your email address and password and deletion of all data in your user account.

<h4>20. END OF TERMS OF SERVICE</h4>

If you have any questions or concerns regarding this Agreement, please contact us at <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>.
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </section>
@endsection
