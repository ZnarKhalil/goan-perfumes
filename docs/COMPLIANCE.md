# Compliance Checklist

This document is a practical implementation checklist for Goan Perfume, a Germany-based perfume shop website.

It is not legal advice. Before launch, the final legal texts and business process should be checked by a German e-commerce/privacy lawyer or a qualified compliance provider.

## Current Scope

The current project is a product showcase website, not a checkout-enabled online shop.

Current behavior:

- Visitors browse products, variants, prices, categories, and filters.
- Visitors contact the shop by WhatsApp, phone, email, or social links.
- The website does not create carts, orders, payments, invoices, or shipment records.
- Sales may still happen later through WhatsApp, email, phone, or another external process.

Because of this, the website needs legal pages, privacy/cookie compliance, product information accuracy, and contact transparency now. Full checkout, payment, cart, and order-flow compliance becomes required only when the site starts selling directly online.

## Required Now

### 1. Impressum

Status: required now.

Why: German commercial websites must provide provider identification that is easy to find, directly reachable, and permanently available.

What it is: A legal notice page identifying who operates the website.

Implement:

- Add a public `Impressum` page.
- Link it from the footer and any legal navigation.
- Include the exact legal operator name.
- Include full postal address.
- Include email address and a fast contact channel.
- Include phone number if used as a business contact.
- Include VAT ID if the business has one.
- Include Handelsregister, register number, and managing director if applicable.
- Include responsible person for editorial content if the site publishes editorial/promotional content that requires it.

Source:

- German Digital Services Act, provider information: https://www.gesetze-im-internet.de/ddg/__5.html

### 2. Privacy Policy

Status: required now.

Why: The site processes personal data when users contact the shop, when the server logs visits, when cookies are stored, when analytics/social embeds are used, or when third-party services receive user data.

What it is: A `Datenschutzerklaerung` / privacy policy explaining how personal data is processed.

Implement:

- Add a public privacy policy page.
- Link it from the footer and cookie banner/settings.
- Explain the controller/business identity.
- Explain each processing purpose:
  - Website delivery and server logs.
  - Contact by WhatsApp, phone, email, and social links.
  - Analytics, tracking, maps, embedded content, or pixels if used.
  - Admin login/security logs if relevant.
- State the legal basis for each purpose.
- List processors and third-party services, including hosting, email, analytics, social media, CDN, and storage providers.
- Explain retention periods or retention criteria.
- Explain user rights: access, correction, erasure, restriction, objection, portability, complaint to authority.
- Explain international data transfers if using providers outside the EU/EEA.
- Explain consent withdrawal if processing is based on consent.

Source:

- GDPR, especially transparency and information duties: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32016R0679

### 3. Cookie And Tracking Consent

Status: required now if any non-essential cookies, analytics, tracking pixels, external embeds, or similar storage/access technologies are used.

Why: Non-essential storage/access on the user's device generally needs prior consent. Consent must be specific, informed, freely given, and withdrawable.

What it is: A consent system that blocks optional tracking until the visitor agrees.

Implement:

- Audit all scripts and embeds.
- Classify cookies/scripts as:
  - Essential: needed for security, language preference, session, or requested functionality.
  - Non-essential: analytics, ads, remarketing, social pixels, heatmaps, embedded media tracking.
- Show a cookie banner only if non-essential tools are present.
- Provide `Accept all`, `Reject all`, and granular settings.
- Do not pre-select non-essential categories.
- Do not load non-essential scripts before consent.
- Add a permanent `Cookie settings` link so users can change consent later.
- Store consent state and version.
- Update the privacy policy to match the actual tools.

Source:

- GDPR consent rules: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32016R0679
- German device/cookie access rule: https://www.gesetze-im-internet.de/ttdsg/__25.html

### 4. Contact Transparency

Status: required now.

Why: The site sends users to direct sales/advice channels. Users need to know how to reach the business and what channel they are opening.

What it is: Clear business contact details and honest contact CTAs.

Implement:

- Keep the contact page.
- Make WhatsApp, email, phone, and social links clear.
- Avoid wording that implies an online purchase is completed on the website.
- Keep product CTA wording as inquiry/contact wording, for example `Verfuegbarkeit direkt anfragen`.
- If WhatsApp is used for sales, mention in the privacy policy that WhatsApp/Meta may receive communication metadata and message content depending on usage.

### 5. Product Price Presentation

Status: required now because prices are shown.

Why: Even without checkout, consumer-facing price displays should be clear and not misleading.

What it is: Accurate product/variant price display.

Implement:

- Show prices as consumer gross prices including VAT where applicable.
- Add legal price wording near price displays or globally, for example `inkl. MwSt.`.
- If shipping is possible after direct contact, add `zzgl. Versand` or explain shipping is clarified during direct contact.
- If price is not final or availability-dependent, use `Preis auf Anfrage` and avoid showing a misleading fixed price.
- Keep compare-at prices honest and only show them if the reference price is defensible.

### 6. Perfume And Cosmetics Product Information

Status: required now for any perfume made available to consumers.

Why: Perfumes are cosmetic products under EU cosmetics rules. Product claims and displayed information must not mislead, and products made available on the EU market must comply with cosmetics requirements.

What it is: Product-level compliance data for perfumes.

Implement:

- For each product, store and display or make available:
  - Brand and product name.
  - Variant size/volume.
  - Ingredients / INCI list where available.
  - Required fragrance allergens where applicable.
  - Warnings and precautions.
  - Responsible person in the EU.
  - Country of origin for imported products if required.
  - Batch/traceability internally, even if not shown publicly.
- Avoid unsupported claims such as medical effects, guaranteed longevity, or misleading luxury/origin claims.
- If the shop imports, private-labels, relabels, or creates perfumes, confirm responsible person, safety assessment, product information file, and CPNP notification obligations before selling.

Source:

- EU Cosmetics Regulation 1223/2009: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32009R1223

### 7. Accessibility Basics

Status: required now as a quality baseline; legally important especially if BFSG applies to the business.

Why: German accessibility rules apply to many consumer-facing digital services, including e-commerce services. Microenterprise exemptions may apply, but the site should still be built accessibly.

What it is: The site should be usable by keyboard users, screen readers, and users with visual/motor impairments.

Implement:

- Use semantic headings and landmarks.
- Keep keyboard navigation working for menus, filters, links, and language switcher.
- Ensure visible focus states.
- Provide alt text for product/category images.
- Maintain sufficient text contrast.
- Make form fields and interactive controls properly labelled.
- Ensure Arabic RTL layout does not break navigation or reading order.
- Add an accessibility statement if legally required for the business.

Source:

- European Accessibility Act: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32019L0882

### 8. Packaging / LUCID Operational Check

Status: required now if the business ships packaged goods in Germany, even when orders are arranged outside the website.

Why: German packaging law can apply to sellers who place sales, shipping, or product packaging on the German market.

What it is: Registration and system participation for packaging responsibility.

Implement outside the website:

- Check whether the business must register with Verpackungsregister LUCID.
- Check whether shipping packaging, sales packaging, and imported product packaging require system participation.
- Keep LUCID registration and dual-system contract records.
- If needed later, add LUCID or packaging compliance info to internal admin/business documentation, not necessarily public pages.

Source:

- Zentrale Stelle Verpackungsregister: https://www.verpackungsregister.org/

## Required If Direct Sales Continue Outside The Website

This section applies when the website stays checkout-free but the business accepts orders by WhatsApp, email, phone, Instagram, or similar channels.

### 1. Distance Selling Information

Status: required for the sales process, even if not implemented as website checkout.

Why: If customers order remotely, consumer distance-selling duties can apply to the direct communication and confirmation flow.

What it is: Information the customer receives before placing a binding order.

Implement in the external sales process:

- Send clear product identity, size, price including VAT, shipping costs, delivery time, payment method, seller identity, and withdrawal information before the customer commits.
- Keep proof of what was sent to the customer.
- Send confirmation on a durable medium, usually email or downloadable PDF/message record.

### 2. Withdrawal Notice

Status: required for consumer distance sales unless an exception applies.

Why: Consumers usually have a withdrawal right for distance sales.

What it is: A `Widerrufsbelehrung` and model withdrawal form.

Implement:

- Prepare a German withdrawal notice.
- Prepare a model withdrawal form.
- Send it before or at order confirmation.
- Explain return address and return shipping cost responsibility.
- Be careful with sealed goods exceptions. Perfume may not automatically be excluded; legal review is needed before relying on hygiene/seal exceptions.

Source:

- Consumer Rights Directive overview: https://commission.europa.eu/law/law-topic/consumer-protection-law/consumer-contract-law/consumer-rights-directive_en

### 3. Terms For Direct Orders

Status: strongly recommended for direct sales.

Why: Terms reduce ambiguity around delivery, returns, payment, retention of title, defects, and governing law.

What it is: AGB or sales terms used in WhatsApp/email/phone orders.

Implement:

- Provide AGB before contract conclusion.
- Keep terms clear and German-consumer compliant.
- Include seller identity, contract conclusion process, delivery, payment, retention of title, defects, withdrawal reference, and dispute handling.

## Required When Online Selling Is Added

This section becomes required if the website adds cart, checkout, order creation, online payment, invoices, customer accounts for orders, delivery tracking, or any equivalent website-based purchase flow.

### 1. Cart And Checkout Flow

Status: required when buying on the site exists.

Why: The buyer must clearly understand the paid order before submitting it.

What it is: A compliant order process from cart to final order button.

Implement:

- Cart page with products, variants, quantity, price, VAT, discounts, and shipping estimate.
- Checkout page with billing/shipping details, delivery method, payment method, and legal checkboxes where appropriate.
- Final review step immediately before order submission.
- Show essential product characteristics, total price, VAT, shipping costs, delivery time, subscription/recurring terms if any, and withdrawal notice.
- Final purchase button must clearly indicate payment obligation, for example `Zahlungspflichtig bestellen` or `Jetzt kaufen`.
- Do not use vague button text like `Weiter`, `Bestellen`, or `Absenden` for the final paid order action.

Source:

- German button solution, BGB section 312j: https://www.gesetze-im-internet.de/bgb/__312j.html

### 2. Order Confirmation

Status: required when online orders exist.

Why: Customers need durable proof of the contract and legal information.

What it is: Email or durable confirmation after order placement.

Implement:

- Send order confirmation email.
- Include order number, customer data, products, prices, VAT, shipping, payment method, delivery address, seller identity, AGB, withdrawal notice, and privacy links.
- Store the exact legal-text versions accepted at purchase time.

### 3. Payment Compliance

Status: required when online payment exists.

Why: Payment data is sensitive and providers have legal/security requirements.

What it is: Safe payment provider integration.

Implement:

- Use hosted/tokenized payment providers such as Stripe, PayPal, Klarna, or bank transfer flow.
- Do not store raw card data.
- Update privacy policy with payment providers and data transfers.
- Show payment fees only where legally allowed.
- Handle payment success, failure, cancellation, refunds, and webhook verification.
- Log payment state changes without exposing sensitive payment details.

### 4. Orders, Invoices, Refunds, And Returns

Status: required when online orders exist.

Why: The app becomes a system of record for customer purchases.

What it is: Operational order management.

Implement:

- Add database tables for orders, order items, addresses, payments, refunds, shipments, and status history.
- Store immutable order snapshots, not just product IDs and current prices.
- Generate invoices or integrate with accounting software.
- Add refund/return workflow.
- Add customer support view for order lookup.
- Add stock handling if inventory is managed by the website.

### 5. Shipping And Dangerous Goods

Status: required when the website promises shipping.

Why: Perfumes often contain alcohol and may be treated as flammable goods by carriers.

What it is: Delivery rules and carrier restrictions.

Implement:

- Define shipping countries.
- Define carrier-specific restrictions for perfume.
- Show delivery times and shipping costs before checkout.
- Block shipping destinations or methods the carrier does not support.
- Add labels/processes required by the carrier for perfume shipments.

### 6. Product Safety Online Listing Data

Status: required when products are offered for distance sale.

Why: EU product safety rules require online listings to include enough safety and economic-operator information.

What it is: Product listing data that identifies the product and responsible parties.

Implement:

- Show manufacturer/brand contact where required.
- Show EU responsible person or importer where required.
- Show product identifier and image.
- Show warnings and safety information in the relevant language.
- Keep a recall/contact process for affected customers.

Source:

- General Product Safety Regulation 2023/988: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32023R0988

### 7. Customer Accounts And GDPR Operations

Status: required if accounts/order history are added.

Why: Accounts increase the volume and sensitivity of personal data.

What it is: Data protection controls for customer data.

Implement:

- Update privacy policy for accounts, order history, payment metadata, delivery addresses, and support messages.
- Add account deletion or anonymization process where legally possible.
- Add export/access workflow for data subject requests.
- Set retention rules for orders, invoices, logs, abandoned carts, and marketing consent.
- Secure customer accounts with strong password, email verification, rate limiting, and optional 2FA if appropriate.

### 8. Marketing, Newsletter, And Retargeting

Status: required if marketing tools are added.

Why: Marketing consent and tracking are high-risk GDPR/cookie areas.

What it is: Consent-based marketing controls.

Implement:

- Newsletter double opt-in.
- Consent log with timestamp, source, text version, and email/IP where appropriate.
- Unsubscribe links in every marketing email.
- No retargeting pixels before consent.
- Separate consent for email marketing and tracking/ads.

## Recommended Roadmap

### Phase 1: Current Showcase Compliance

Priority: before public launch.

Implement:

- Impressum page.
- Privacy policy page.
- Cookie settings system if non-essential tools exist.
- Footer links to legal pages.
- Product page copy that clearly says inquiry/contact, not checkout.
- Price wording: `inkl. MwSt.` and shipping/availability clarification.
- Product compliance fields for INCI, warnings, responsible person, and origin where needed.

### Phase 2: Direct-Sales Process Compliance

Priority: before accepting binding orders by WhatsApp/email/phone.

Implement outside the app or in admin templates:

- Message/email templates for offer and order confirmation.
- Withdrawal notice and withdrawal form.
- AGB for direct orders.
- Proof/archive process for customer acceptance and sent legal texts.

### Phase 3: Online Checkout Readiness

Priority: before adding cart/payment/order features.

Implement:

- Legal review of checkout flow.
- Cart, checkout, order, payment, invoice, refund, and shipping models.
- Final paid order button wording.
- Payment provider integration.
- Updated privacy policy, AGB, withdrawal, shipping, and payment pages.
- Product safety data on listings.
- Accessibility audit of checkout.

## Source List

- GDPR: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32016R0679
- German Digital Services Act section 5: https://www.gesetze-im-internet.de/ddg/__5.html
- German cookie/device access rule section 25: https://www.gesetze-im-internet.de/ttdsg/__25.html
- German paid-order button rule section 312j BGB: https://www.gesetze-im-internet.de/bgb/__312j.html
- EU Consumer Rights Directive overview: https://commission.europa.eu/law/law-topic/consumer-protection-law/consumer-contract-law/consumer-rights-directive_en
- EU Cosmetics Regulation 1223/2009: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32009R1223
- EU General Product Safety Regulation 2023/988: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32023R0988
- European Accessibility Act: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32019L0882
- Zentrale Stelle Verpackungsregister: https://www.verpackungsregister.org/
