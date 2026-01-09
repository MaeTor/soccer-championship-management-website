import './bootstrap';

  const th = document.getElementById("delete-th");
  const popover = document.getElementById("delete-popover");

  th.addEventListener("click", () => {
    popover.showPopover();
  });