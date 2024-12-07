document.addEventListener("alpine:init", () => {
    Alpine.data("display", () => ({
        // main alpine js component
        selection: ["cash", "card", "wallet", "upi", "all"],
        filtering: false,

        // start and end date
        daterange_: {
            start: null,
            end: null,
        },

        // tender value
        tender_: "all",
        timeline_: "ThisYear",

        select(item) {
            this.selection = ["cash", "card", "wallet", "upi", "all"];
            this.filtering = true;
            this.selection = this.selection.filter((item_) => item_ == item);
        },

        displayHas(item) {
            return this.selection.includes(item) == true;
        },

        reset() {
            this.tender_ = "all";
            this.timeline_ = "ThisYear";
            this.daterange_.start = null;
            this.daterange_.end = null;

            this.filtering = false;
            this.selection = ["cash", "card", "wallet", "upi", "all"];
        },

        // filter datasets
        _filter() {
            /**
             *  prepare the dataset
             */
            dataset = {
                timeline_: "",
                tender_: "",
                from: null,
                to: null,
            };

            /**
             * Upgrade the Dataset
             */
            if (!this.daterange_.start && !this.daterange_.end) {
                dataset.timeline_ = !this.timeline_
                    ? "ThisYear"
                    : this.timeline_;
                dataset.tender_ = this.tender_;
                dataset.from = null;
                dataset.to = null;
            } else {
                this.timeline_ = "";
                dataset.tender_ = this.tender_;
                dataset.from = this.daterange_.start;
                dataset.to = this.daterange_.end;
            }

            /**
             * Select the tender
             */
            this.select(this.tender_);

            /**
             * Send the Post Data
             */
            return dataset;
        },
    }));
});
