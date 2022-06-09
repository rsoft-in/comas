function generatePagesTable(data) {
    var _html = "";
    for (let i = 0; i < data.pages.length; i++) {
        _html += "<tr>\n"
            + "<td>" + data.pages[i].page_title + "</td>\n"
            + "<td>" + data.pages[i].page_url_slug + "</td>\n"
            + "<td>" + data.pages[i].page_order + "</td>\n"
            + "<td>" + (data.pages[i].page_published == 1 ? "<i class=\"bi bi-check2\"></i>" : "")  + "</td>\n"
            + "<td class=\"text-end\">"
            + "<a class=\"ms-3\" href=\"#\" title='Edit' onclick=\"edit('" + data.pages[i].page_id + "')\"><i class=\"bi bi-pencil\"></i></a>"
            + "<a class=\"ms-3\" href=\"#\" title='Delete' onclick=\"delete('" + data.pages[i].page_id + "')\"><i class=\"bi bi-trash\"></i></a>"
            + "</td>"
            + "</tr>";
    }
    return _html;
}