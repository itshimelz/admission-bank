document.addEventListener('DOMContentLoaded', async () => {
  const detailsContainer = document.getElementById('uni-details');
  const params = new URLSearchParams(window.location.search);
  const uniName = params.get('name');

  try {
    // load both public and private data
    const [publicData, privateData] = await Promise.all([
      fetch('./data/public_universities.json').then(res => res.json()),
      fetch('./data/private_universities.json').then(res => res.json()),
    ]);
    const allUnis = [
      ...publicData.map(u => ({ ...u, type: 'Public' })),
      ...privateData.map(u => ({ ...u, type: 'Private' })),
    ];

    if (!uniName) {
      detailsContainer.innerHTML = '<p class="text-danger text-center">No university specified.</p>';
      return;
    }

    const uni = allUnis.find(u => u.name === uniName);
    if (!uni) {
      detailsContainer.innerHTML = '<p class="text-danger text-center">University not found.</p>';
      return;
    }

    detailsContainer.innerHTML = `
      <div class="card mx-auto" style="max-width:600px;">
        <div class="card-body">
          <h2 class="card-title">${uni.name}</h2>
          <p><strong>Type:</strong> ${uni.type}</p>
          <p><strong>Website:</strong> <a href="https://${uni.website}" target="_blank">${uni.website}</a></p>
        </div>
      </div>
    `;
  } catch (err) {
    console.error(err);
    detailsContainer.innerHTML = '<p class="text-danger text-center">Error loading university data.</p>';
  }
});
