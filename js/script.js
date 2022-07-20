
function createAttributeField(attributesField, attribute, unit, name) 
{
    var field = document.createElement("p");
	field.innerHTML = attribute + " (" + unit + ") ";

	var input = document.createElement("input");
	input.type = "text";
	input.name = name;
	input.id = attribute.toLowerCase();

	field.appendChild(input);
	attributesField.appendChild(field);
}

function typeDescription(attributesField, attribute)
{
	var description = document.createElement("p");
	description.innerHTML = "<b>Please, provide " + attribute + "</b>";
	attributesField.appendChild(description);
}

// Change dynamically the Form according to the selected Type.
function addAttributeFields()
{
	var attributesField = document.getElementById("attributes");
	const TYPES = ["Disc", "Book", "Furniture"];
	const UNITS = ["MB", "KG", "CM"];
	const ATTRIBUTES = [["Size"], ["Weight"], ["Height", "Width", "Length"]];
	const DESCRIPTIONS = ["size", "weight", "dimensions"];

	// Clean up the portion of the Form where the attributes are dynamically displayed
	while (attributesField.hasChildNodes()) {
		attributesField.removeChild(attributesField.lastChild);
	}

	var type = document.getElementById("productType").value;
	
	if(type !== "")
	{
		var typeIdx = TYPES.indexOf(type);
		var description = DESCRIPTIONS[typeIdx];
		var unit = UNITS[typeIdx];
		var attributes = ATTRIBUTES[typeIdx] || [];
		var len = attributes.length;

		for (var i = 0; i < len; i++) {
			var name = "attributes" + i;
			createAttributeField(attributesField, attributes[i], unit, name);
		}

		typeDescription(attributesField, description);
	}
}