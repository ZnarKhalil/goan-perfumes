# Compliance Checklist

This document is a practical implementation checklist for Goan Perfume, a Germany-based perfume shop website.

It is not legal advice. Before launch, the final legal texts and business process should be checked by a German e-commerce/privacy lawyer or a qualified compliance provider.

## Current Scope

The current project is a product showcase and contact website.

Current behavior:

- Visitors browse products, variants, prices, categories, and filters.
- Visitors contact the shop by WhatsApp, phone, email, or social links.
- The website does not process purchases.

Because of this, this checklist only covers what the current website must have: legal pages, privacy/cookie disclosures, contact transparency, accurate product and price presentation, accessibility basics, and packaging checks where the business ships packaged goods.

## Required For The Current Website

### 1. Impressum

Why: German commercial websites must provide provider identification that is easy to find, directly reachable, and permanently available.

What it is: A legal notice page identifying who operates the website.

Required content:

- Include the exact legal operator name.
- Include full postal address.
- Include email address.
- Include phone number.

Source:

- German Digital Services Act, provider information: https://www.gesetze-im-internet.de/ddg/__5.html

### 2. Privacy Policy

Why: The site processes personal data when users contact the shop, when the server logs visits, when cookies are stored, when analytics/social embeds are used, or when third-party services receive user data.

What it is: A `Datenschutzerklaerung` / privacy policy explaining how personal data is processed.

Required content:

- Explain the controller/business identity.
- Explain each processing purpose:
  - Website delivery and server logs.
  - Contact by WhatsApp, phone, email, and social links.
  - Google Analytics, only after consent.
  - Cookies and local storage used for necessary preferences and consent choices.
- State the legal basis for each purpose.
- List processors and third-party services, including hosting, email, analytics, social media, CDN, and storage providers where used.
- Explain retention periods or retention criteria.
- Explain user rights: access, correction, erasure, restriction, objection, portability, complaint to authority.
- Explain international data transfers if using providers outside the EU/EEA.
- Explain consent withdrawal if processing is based on consent.
- Have the final text legally reviewed before launch.

Source:

- GDPR, especially transparency and information duties: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32016R0679

### 3. Contact Transparency

Why: The site sends users to contact/advice channels. Users need to know how to reach the business and what channel they are opening.

What it is: Clear business contact details and honest contact CTAs.

Required content:

- Show accurate WhatsApp, email, phone, and social links.
- Make contact links clear when they open WhatsApp, phone, email, Instagram, TikTok, Facebook, or another external service.
- Keep the privacy policy aligned with WhatsApp, Instagram, TikTok, and Facebook processing if those channels are used for contact.

### 4. Product Price Presentation

Why: Consumer-facing price displays should be clear and not misleading.

What it is: Accurate product/variant price display.

Required content:

- Show final consumer prices clearly.
- Use the correct VAT wording for the business status. If Kleinunternehmer pricing applies, use appropriate Kleinunternehmer wording instead of claiming displayed VAT.
- If shipping is possible after direct contact, add shipping clarification near price displays or in a clearly reachable legal/info area.
- If price is not final or availability-dependent, use `Preis auf Anfrage` and avoid showing a misleading fixed price.
- Keep compare-at prices honest and only show them if the reference price is defensible.

### 5. Perfume And Cosmetics Product Information

Why: Perfumes are cosmetic products under EU cosmetics rules. Product claims and displayed information must not mislead, and products made available on the EU market must comply with cosmetics requirements.

What it is: Product-level compliance data for perfumes.

Required content/process:

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

### 6. Accessibility Basics

Why: German accessibility rules apply to many consumer-facing digital services, including e-commerce services. Microenterprise exemptions may apply, but the site should still be built accessibly.

What it is: The site should be usable by keyboard users, screen readers, and users with visual/motor impairments.

Required baseline:

- Use semantic headings and landmarks.
- Keep keyboard navigation working for menus, filters, links, and language switcher.
- Ensure visible focus states.
- Provide alt text for product images.
- Maintain sufficient text contrast.
- Make form fields and interactive controls properly labelled.
- Ensure Arabic RTL layout does not break navigation or reading order.
- Add an accessibility statement if legally required for the business.

Source:

- European Accessibility Act: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32019L0882

### 7. Packaging / LUCID Operational Check

Why: German packaging law can apply to sellers who place sales, shipping, or product packaging on the German market.

What it is: Registration and system participation for packaging responsibility.

Required business check if Goan Perfume ships packaged goods:

- Check whether the business must register with Verpackungsregister LUCID.
- Check whether shipping packaging, sales packaging, and imported product packaging require system participation.
- Keep LUCID registration and dual-system contract records.

Source:

- Zentrale Stelle Verpackungsregister: https://www.verpackungsregister.org/

## Source List

- GDPR: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32016R0679
- German Digital Services Act section 5: https://www.gesetze-im-internet.de/ddg/__5.html
- German cookie/device access rule section 25: https://www.gesetze-im-internet.de/ttdsg/__25.html
- EU Cosmetics Regulation 1223/2009: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32009R1223
- European Accessibility Act: https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=CELEX:32019L0882
- Zentrale Stelle Verpackungsregister: https://www.verpackungsregister.org/
