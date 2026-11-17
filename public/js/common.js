// وظائف مشتركة لجميع الصفحات

// مسح بيانات الجلسة
function clearSessionData() {
    localStorage.clear();
    sessionStorage.clear();
    alert('تم مسح جميع بيانات الجلسة بنجاح');
}

// توليد كود منطقة عشوائي
function generateRandomAreaCode(prefix = '') {
    const areas = {
        'ALEP': 'حلب',
        'DAM': 'دمشق',
        'HOMS': 'حمص',
        'HAMA': 'حماة',
        'LAT': 'اللاذقية',
        'DER': 'دير الزور',
        'RAQ': 'الرقة',
        'HAS': 'الحسكة',
        'IDLIB': 'إدلب'
    };
    
    const areaKeys = Object.keys(areas);
    const randomArea = areaKeys[Math.floor(Math.random() * areaKeys.length)];
    const division = String.fromCharCode(65 + Math.floor(Math.random() * 8)) + 
                   Math.floor(Math.random() * 9 + 1);
    let numbers = '';
    for (let i = 0; i < 3; i++) {
        numbers += Math.floor(Math.random() * 10);
    }
    
    return {
        code: `${randomArea}-${division}-${numbers}`,
        areaName: areas[randomArea]
    };
}

// تحميل الحماية عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // إضافة زر مسح البيانات في الفوتر
    const footer = document.querySelector('.footer');
    if (footer) {
        const clearBtn = document.createElement('button');
        clearBtn.className = 'btn-secondary';
        clearBtn.innerHTML = '<i class="fas fa-trash-alt"></i> مسح بيانات الجلسة';
        clearBtn.style.marginTop = '10px';
        clearBtn.onclick = clearSessionData;
        
        const footerContainer = footer.querySelector('.container');
        if (footerContainer) {
            footerContainer.appendChild(clearBtn);
        }
    }
});