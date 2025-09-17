async function checkImageFormatSupport(format) {
  return new Promise(resolve => {
    const image = new Image();
    image.onload = () => resolve(true);
    image.onerror = () => resolve(false);
    
    // Asigna una pequeña imagen codificada en base64 del formato que quieres probar.
    let imageData;
    if (format === 'webp') {
      imageData = 'data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=';
    } else if (format === 'avif') {
      imageData = 'data:image/avif;base64,AAAAFGZ0eXBhdmLmAAAAAGF2aWZtaWYxbWlhZk1BMUIAAADybWV0YQAAAAAAAAAoaGRscgAAAAAAAAAAcGljdAAAAAAAAAAAAAAAAGxpYmF2aWYAAAAADnBpdG0AAAAAAAEAAAAeaWxvYwAAAABEAAABAAEAAAABAAABGgAAABcAAAAoaWluZgAAAAAAAQAAABppbmZlAgAAAAABAABhdjAxQ29sb3IAAAAAamlwcnAAAABLaXBjbwAAABRpc3BlAAAAAAAAAAEAAAABAAAAEHBpeGkAAAAAAwgAAAYAAAAAEGF2MUOBAAAAAAAAFWlwbWEAAAAAAAAAAQABBAECg4QAAAAWbWRhdAAAAAAAAAAGggrQEAAAEgAAABCw';
    }
    
    image.src = imageData;
  });
}

// Cómo usarlo:
checkImageFormatSupport('webp').then(isSupported => {
  if (isSupported) {
    console.log('¡WebP es compatible!');
    document.documentElement.classList.add('webp');
  } else {
    console.log('WebP no es compatible.');
    document.documentElement.classList.add('no-webp');
  }
});

checkImageFormatSupport('avif').then(isSupported => {
  if (isSupported) {
    console.log('¡AVIF es compatible!');
    document.documentElement.classList.add('avif');
  } else {
    console.log('AVIF no es compatible.');
    document.documentElement.classList.add('no-avif');
  }
});