<script>
    (function() {

        async function insertFaqJsonLd() {
            //ない場合もある
            var url = location.pathname
            var faq = "";
            faq = document.querySelectorAll(".faq__con");
            const entries = [];
            // console.log(location.pathname);
            if (faq.length >= 1) {
                for (let i = 0; i < faq.length; i++) {
                    const questionElement = faq[i].querySelector('.faq__question');
                    const answerElement = faq[i].querySelector('.faq__answer p');

                    if (questionElement && answerElement) {
                        const q = questionElement.textContent.trim();
                        const a = answerElement.textContent.trim();

                        createQAEntry(q, a);
                    }
                }

                function createQAEntry(q, a) {
                    // console.log(q);
                    entries.push({
                        "@type": "Question",
                        "name": q,
                        acceptedAnswer: {
                            "@type": "Answer",
                            "text": a,
                        },
                    });
                }

                const website_obj = {
                    "@context": "https://schema.org",
                    "@type": "FAQPage",
                    "mainEntity": entries,
                };
                return website_obj;

            }
        }

       

        async function allInsertJsonLd() {
            const script = document.createElement("script");
            script.setAttribute("type", "application/ld+json");
            let allJsonLd = [];
            if (await insertFaqJsonLd() != null) allJsonLd.push(await insertFaqJsonLd(), );
            script.innerText = JSON.stringify(allJsonLd);
            document.head.appendChild(script);
        }
        window.addEventListener("load", allInsertJsonLd, false);
    })();
</script>